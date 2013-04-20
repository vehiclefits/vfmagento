<?php

/**
 * Vehicle Fits Free Edition - Copyright (c) 2008-2010 by Vehicle Fits, LLC
 * PROFESSIONAL IDENTIFICATION:
 * "www.vehiclefits.com"
 * PROMOTIONAL SLOGAN FOR AUTHOR'S PROFESSIONAL PRACTICE:
 * "Automotive Ecommerce Provided By Vehicle Fits llc"
 *
 * All Rights Reserved
 * VEHICLE FITS ATTRIBUTION ASSURANCE LICENSE (adapted from the original OSI license)
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the conditions in license.txt are met
 */
class VF_Level implements VF_Configurable
{

    protected $id;
    protected $title;
    protected $type;
    /** @var VF_Level_Finder */
    protected $finder;
    /** @var VF_Schema */
    protected $schema;
    /** @var Zend_Config */
    protected $config;

    /**
     * @param mixed $type
     * @param mixed $id
     * @return Elite_Vaf_Model_Abstract
     */
    function __construct($type, $id = 0)
    {
        if ($id && !in_array($type, $this->getSchema()->getLevels()))
        {
            throw new VF_Level_Exception_InvalidLevel('[' . $type . '] is an invalid level');
        }
        $this->type = $type;
        $this->id = $id;
    }

    function identityMap()
    {
        return VF_Level_IdentityMap::getInstance();
    }

    function getConfig()
    {
        if (!$this->config instanceof Zend_Config)
        {
            $this->config = Elite_Vaf_Helper_Data::getInstance()->getConfig();
        }
        return $this->config;
    }

    function setConfig(Zend_Config $config)
    {
        $this->config = $config;
    }

    /** @return VF_Level_Finder */
    function getFinder()
    {
        if (!( $this->finder instanceof VF_Level_Finder ))
        {
            $this->finder = new VF_Level_Finder();
        }
        $this->finder->setConfig($this->getConfig());
        return $this->finder;
    }

    function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        if (0 == $this->id)
        {
            $this->id = $id;
        } else
        {
            throw new Exception('cannot set id if its previously already set');
        }
    }

    function setTitle($title)
    {
        $this->title = trim($title);
        return $this;
    }

    function getTitle()
    {
        return (string) $this->title;
    }

    function getLabel()
    {
        return $this->getType();
    }

    function getNextLevel()
    {
        return $this->getSchema()->getNextLevel($this->getType());
    }

    function getPrevLevel()
    {
        return $this->getSchema()->getPrevLevel($this->getType());
    }

    function createEntity($level, $id = 0)
    {
        return new VF_Level($level, $id);
    }

    function getType()
    {
        return $this->type;
    }

    function getChildCount()
    {
        return $this->getFinder()->getChildCount($this);
    }

    function getChildren()
    {
        return $this->getFinder()->getChildren($this);
    }

    /**
     * Save the model
     *
     * @param mixed $parent_id optional parent_id this model is being saved under
     * @return int primary key id of created entity
     */
    function save($parent_id = 0, $requestedSaveId = null, $createDefinition = true)
    {
        if ('' == trim($this->getTitle()))
        {
            throw new Exception('Must have a non blank title to save ' . $this->getType());
        }

        $levelId = $this->findEntityIdByTitle($parent_id);
        if ($levelId)
        {
            $this->id = $levelId;
            if ($createDefinition)
            {
                $this->createDefinition($parent_id);
            }
            return $levelId;
        }

        if ($requestedSaveId && $this->requestedIdCorrespondsToExistingRecord($requestedSaveId))
        {
            $this->id = $requestedSaveId;
        }

        if ($this->getId())
        {
            $saver = new VF_Level_Finder_Updater($this, $parent_id);
            return $saver->save();
        }

        $saver = new VF_Level_Finder_Inserter($this, $parent_id);
        $saver->setConfig($this->getConfig());
        $levelId = $saver->save($requestedSaveId);

        if ($this->getSchema()->hasGlobalLevel() && $createDefinition)
        {
            $this->createDefinition($parent_id);
        }

        return $levelId;
    }

    function createDefinition($parent_id)
    {
        if ($this->getType() == $this->getSchema()->getLeafLevel())
        {
            $this->createFullDefinition($parent_id);
        } else if ($this->getType() == $this->getSchema()->getRootLevel())
        {
            $this->createPartialDefinitionForRootLevel();
        } else
        {
            $this->createPartialDefinition($parent_id);
        }
    }

    function createPartialDefinitionForRootLevel()
    {
        $titles = array($this->getType() => $this->getTitle());
        $bind = array($this->getSchema()->getRootLevel() . '_id' => $this->getId());
        if (!count($this->vehicleFinder()->findByLevelIds($bind, true)))
        {
            $this->getReadAdapter()->insert('elite_' . $this->getSchema()->id() . '_definition', $bind);
        }
    }

    function createPartialDefinition($parent_id)
    {
        $params = array();
        if (is_array($parent_id))
        {
            $params = array_merge($params, $parent_id);
        } else
        {
            $params[$this->getPrevLevel()] = $parent_id;
        }
        foreach ($this->getSchema()->getNextLevels($this->getPrevLevel()) as $level)
        {
            $params[$level] = 0;
        }

        $vehicles = $this->vehicleFinder()->findByLevelIds($params, true);
        foreach ($vehicles as $vehicle)
        {
            $values = $vehicle->toValueArray();
            $values[$this->getType()] = $this->getId();

            $bind = array();
            foreach ($this->getSchema()->getLevels() as $level)
            {
                $bind[$level . '_id'] = $values[$level];
            }

            $titles = $vehicle->toTitleArray();
            $titles[$this->getType()] = $this->getTitle();
            if (!count($this->vehicleFinder()->findByLevelIds($bind, true)))
            {
                $this->getReadAdapter()->insert($this->getSchema()->definitionTable(), $bind);
            }
        }
    }

    function createFullDefinition($parent_id)
    {
        if (is_array($parent_id))
        {
            foreach ($this->getSchema()->getLevels() as $level)
            {
                $row[$level . '_id'] = isset($parent_id[$level]) ? $parent_id[$level] : false;
            }
        } else
        {
            $rootTable = $this->getSchema()->levelTable($this->getSchema()->getRootLevel());
            $select = $this->getReadAdapter()->select()
                            ->from($rootTable, $this->vehicleFinder()->getColumns());
            $select .= $this->getJoinsNoDefinition();
            $leafTable = $this->getSchema()->levelTable($this->getSchema()->getLeafLevel());
            $select .= sprintf(" WHERE `".$leafTable."`.`id` = %d", $this->getId());

            $row = $this->query($select)->fetch(Zend_Db::FETCH_ASSOC);
        }
        if (!$row)
        {
            return;
        }

        $bind = array();
        foreach ($this->getSchema()->getLevels() as $level)
        {
            $bind[$level . '_id'] = $row[$level . '_id'];
        }

        if (count($this->vehicleFinder()->findByLevelIds($bind)) == 0)
        {
            $this->getReadAdapter()->insert($this->getSchema()->definitionTable(), $bind);
        }
    }

    function vehicleFinder()
    {
        return new VF_Vehicle_Finder($this->getSchema());
    }

    function getJoinsNoDefinition()
    {
        $joins = '';
        $levels = $this->getSchema()->getLevels();

        foreach ($levels as $level)
        {
            if ($level == $this->getSchema()->getRootLevel())
            {
                continue;
            }
            $joins .= sprintf(
                            '
                LEFT JOIN
                    `%1$s`
                ON
                    `%1$s`.`%2$s_id` = `%3$s`.`id`
                ',
                $this->getSchema()->levelTable($level),
                $this->getSchema()->getPrevLevel($level),
                $this->getSchema()->levelTable($this->getSchema()->getPrevLevel($level))
            );
        }
        return $joins;
    }

    function requestedIdCorrespondsToExistingRecord($requestedSaveId)
    {
        $select = $this->getReadAdapter()->select()
                        ->from($this->getTable(), 'count(*)')
                        ->where('id=?', (int) $requestedSaveId);
        $result = $this->getReadAdapter()->query($select);
        return (bool) $result->fetchColumn();
    }

    function delete()
    {
        if (!(int) $this->getId())
        {
            throw new Exception();
        }

        $identityMap = VF_Level_IdentityMap_ByTitle::getInstance();
        $identityMap->remove($this->getType(), $this->getId());

        $this->deleteFits();

        $this->deleteChildren();

        $query = sprintf("DELETE FROM `" . $this->getTable() . "` WHERE   `id` = %d", $this->getId());
        $this->query($query);

        $query = sprintf("DELETE FROM `" . $this->getSchema()->definitionTable() . "` WHERE `" . $this->getType() . "_id` = %d", $this->getId());
        $this->query($query);

        if ($this->getType() == $this->getSchema()->getLeafLevel() && file_exists(ELITE_PATH . '/Vafwheel'))
        {
            $query = sprintf("DELETE FROM `elite_definition_wheel` WHERE `leaf_id` = %d", $this->getId());
            $this->query($query);
        }
    }

    function deleteChildren()
    {
        if ($this->getNextLevel() != '')
        {
            foreach ($this->getChildren() as $child)
            {
                $child->delete();
            }
        }
    }

    /** Recurse this object's hierarchy until we arrive at the year, and then delete all of it's fits */
    function deleteFits()
    {
        if ($this->getNextLevel() != '')
        {
            foreach ($this->getChildren() as $child)
            {
                $child->deleteFits();
            }
            return;
        }

        $mappingsQuery = sprintf(
                        "SELECT `id` FROM `" . $this->getSchema()->mappingsTable() . "` WHERE %s = %d",
                        $this->getReadAdapter()->quoteIdentifier($this->getType() . '_id'),
                        (int) $this->getId()
        );
        $mappingsResult = $this->query($mappingsQuery);
        foreach ($mappingsResult->fetchAll() as $mappingsRow)
        {
            if (file_exists(ELITE_PATH . '/Vafnote'))
            {
                $deleteQuery = sprintf("DELETE FROM `elite_mapping_notes` WHERE `fit_id` = %d", $mappingsRow['id']);
                $this->query($deleteQuery);
            }

            $deleteQuery = sprintf("DELETE FROM `" . $this->getSchema()->mappingsTable() . "` WHERE `id` = %d LIMIT 1", $mappingsRow['id']);
            $this->query($deleteQuery);
        }
    }

    function listAll($parent_id = 0)
    {
        return $this->getFinder()->listAll($this, $parent_id);
    }

    function getSortOrder()
    {
        if ($sort = $this->getSchema()->getSorting($this->getType()))
        {
            return $sort;
        }
        return "ASC";
    }

    function listInUse($parents = array(), $product_id = 0)
    {
        return $this->getFinder()->listInUse($this, $parents, $product_id);
    }

    function listInUseByTitle($parents = array(), $product_id = 0)
    {
        return $this->getFinder()->listInUseByTitle($this, $parents, $product_id);
    }

    function getTable()
    {
        return 'elite_level_' . $this->getSchema()->id() . '_' . $this->getType();
    }

    function getLevels()
    {
        return $this->getSchema()->getLevels();
    }

    function getLeafLevel()
    {
        return $this->getSchema()->getLeafLevel();
    }

    function getRootLevel()
    {
        return $this->getSchema()->getRootLevel();
    }

    /** @return integer ID */
    function findEntityIdByTitle($parent_id = 0)
    {
        return $this->getFinder()->findEntityIdByTitle($this->getType(), $this->getTitle(), $parent_id);
    }

    function getSchema()
    {
        $schema = new VF_Schema();
        $schema->setConfig($this->getConfig());
        return $schema;
    }

    function __toString()
    {
        return $this->getTitle();
    }

    /** @return Zend_Db_Statement_Interface */
    function query($sql)
    {
        return $this->getReadAdapter()->query($sql);
    }

    /** @return Zend_Db_Adapter_Abstract */
    function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }

}