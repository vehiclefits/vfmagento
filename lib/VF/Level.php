<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
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

        $levelId = $this->findEntityIdByTitle();
        if ($levelId)
        {
            $this->id = $levelId;
            return $levelId;
        }

        if ($requestedSaveId && $this->requestedIdCorrespondsToExistingRecord($requestedSaveId))
        {
            $this->id = $requestedSaveId;
        }

        if ($this->getId())
        {
            $saver = new VF_Level_Finder_Updater($this);
            return $saver->save();
        }

        $saver = new VF_Level_Finder_Inserter($this);
        $saver->setConfig($this->getConfig());
        $levelId = $saver->save($requestedSaveId);

        return $levelId;
    }

    function vehicleFinder()
    {
        return new VF_Vehicle_Finder($this->getSchema());
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