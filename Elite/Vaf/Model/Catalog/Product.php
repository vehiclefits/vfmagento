<?php

/**
 * Vehicle Fits Free Edition - Copyright (c) 2008-2010 by Ne8, LLC
 * PROFESSIONAL IDENTIFICATION:
 * "www.vehiclefits.com"
 * PROMOTIONAL SLOGAN FOR AUTHOR'S PROFESSIONAL PRACTICE:
 * "Automotive Ecommerce Provided By Ne8 llc"
 *
 * All Rights Reserved
 * VEHICLE FITS ATTRIBUTION ASSURANCE LICENSE (adapted from the original OSI license)
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the conditions in license.txt are met
 */
class Elite_Vaf_Model_Catalog_Product extends Mage_Catalog_Model_Product implements Elite_Vaf_Configurable
{

    /** @var Collection of Elite_Vaf_Model_Vehicle */
    protected $fits = NULL;
    /** @var Elite_Vaf_Model_Vehicle the customer has associated */
    protected $fit;
    /** @var Zend_Config */
    protected $config;

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

    function getFitModels()
    {
	$fits = $this->getFits();
	$return = array();
	foreach ($fits as $fitRow)
	{
	    $fit = $this->createFitFromRow($fitRow);
	    array_push($return, $fit);
	}
	return $return;
    }

    /**
     * Get a result set for the fits for this product
     */
    function getFits()
    {
	if (!is_null($this->fits))
	{
	    return $this->fits;
	}
	if ($productId = (int) $this->getId())
	{
	    $this->fits = $this->doGetFits($productId);
	    return $this->fits;
	}
	return array();
    }

    function getMinimalPrice()
    {
	if( !$this->currentlySelectedFit() )
        {
	    return parent::getMinimalPrice();
	}
        $selection = $this->currentlySelectedFit();
        $vehicle = $selection->getFirstVehicle();
        if(!$vehicle)
        {
            return parent::getMinimalPrice();
        }
        $customPrice = $this->customPrice($vehicle);
        return $customPrice;
    }

    function getFinalPrice($qty=null)
    {
	if( !$this->currentlySelectedFit() )
        {
	    return parent::getFinalPrice();
	}
        $selection = $this->currentlySelectedFit();
        $vehicle = $selection->getFirstVehicle();
        if(!$vehicle)
        {
            return parent::getFinalPrice();
        }
        $customPrice = $this->customPrice($vehicle);
        if($customPrice)
        {
            return $customPrice;
        }
        return parent::getFinalPrice();
    }

    function getPrice()
    {
        $this->setFitFromGlobalIfNoLocalFitment();
	if( $this->currentlySelectedFit()->isEmpty())
	{
            return parent::getPrice();
	}
        
        $vehicle = $this->currentlySelectedFit()->getFirstVehicle();
        $customPrice = $this->customPrice($vehicle);	
        if($customPrice)
        {
            return $customPrice;
        }
        return parent::getPrice();
    }

    function getFormatedPrice()
    {
	if( $this->currentlySelectedFit() && $customPrice = $this->customPrice($this->currentlySelectedFit()))
	{
	    return $customPrice;
	}
	return parent::getPrice();
    }

    function customPrice($vehicle)
    {
	$select = $this->getReadAdapter()->select();
        $select->from( array('m'=>'elite_mapping' ), array('price') );

        foreach( $vehicle->toValueArray() as $parentType => $parentId )
        {
            if( !in_array( $parentType, $this->getSchema()->getLevels() ) )
            {
                throw new Elite_Vaf_Model_Level_Exception( $parentType );
            }
            if( !(int)$parentId )
            {
                continue;
            }
            $select->where( sprintf( 'm.`%s_id` = ?', $parentType ), $parentId );
        }
        
	$select->where( '`entity_id` = ?', $this->getId() );

        $price = $this->query( $select )->fetchColumn();
        return (!$price) ? null : $price;
    }

    function getOrderBy()
    {
	$schema = new Elite_Vaf_Model_Schema();
	$levels = $schema->getLevels();
	$c = count($levels);
	$sql = '';
	for ($i = 0; $i <= $c - 1; $i++)
	{
	    $sql .= '`' . $levels[$i] . '`' . ( $i < $c - 1 ? ',' : '' );
	}
	return $sql;
    }

    public static function getJoins()
    {
	$joins = '';

	$schema = new Elite_Vaf_Model_Schema();
	$levels = $schema->getLevels();

	$c = count($levels);
	for ($i = 0; $i <= $c - 1; $i++)
	{
	    $joins .= sprintf(
			    '
                LEFT JOIN
                    `elite_%1$s`
                ON
                    `elite_%1$s`.`id` = `elite_mapping`.`%1$s_id`
                ',
			    $levels[$i]
	    );
	}
	return $joins;
    }

    /**
     * Add fit(s)
     *
     * @param array  as described below
     *
     *  Examples -  add make 5 and all its children:
     * array( 'make' => 5 )
     *
     *  ...   is the same as:
     * array( 'make' => 5, 'model' => 0 )
     *
     * ... or add a individual fit:
     * array( 'make' => 5, 'model' => 3, 'year' => 4 )
     *
     * ... is the same as
     * array( 'year' => 4 )
     *
     * etc...
     *
     */
    function addVafFit(array $fitToAdd)
    {
	$vehicles = $this->vehicleFinder()->findByLevelIds($fitToAdd);
	$mapping_id = null;
	foreach ($vehicles as $vehicle)
	{
	    $mapping_id = $this->insertMapping($vehicle);
	}
	return $mapping_id;
    }

    function vehicleFinder()
    {
	return new Elite_Vaf_Model_Vehicle_Finder($this->getSchema());
    }

    function insertMapping(Elite_Vaf_Model_Vehicle $vehicle)
    {
	$mapping = new Elite_Vaf_Model_Mapping($this->getId(), $vehicle);
	return $mapping->save();
    }

    function deleteVafFit($mapping_id)
    {
	$sql = sprintf("DELETE FROM `elite_mapping` WHERE `id` = %d", (int) $mapping_id);
	$this->query($sql);

	if (file_exists(ELITE_PATH . '/Vafnote'))
	{
	    $sql = sprintf("DELETE FROM `elite_mapping_notes` WHERE `fit_id` = %d", (int) $mapping_id);
	    $this->query($sql);
	}
    }

    /** @return boolean */
    function isUniversal()
    {
	$sql = sprintf(
			"
		    SELECT
		        count( * )
		    FROM
		        `elite_mapping`
		    WHERE
		        `entity_id` = %d
		    AND
		        `universal` = 1
		    ",
			(int) $this->getId()
	);
	$result = $this->query($sql);
	$count = $result->fetchColumn();
	return $count == 0 ? false : true;
    }

    /** @param boolean */
    function setUniversal($universal)
    {
	if (!$universal)
	{
	    $query = sprintf('DELETE FROM elite_mapping WHERE universal = 1 AND entity_id = %d', $this->getId());
	    $r = $this->query($query);
	    return;
	}

	$this->query(
		sprintf(
			"
                REPLACE INTO
                    `elite_mapping`
                (
                    `universal`,
                    `entity_id`
                )
                VALUES
                (
                    %d,
                    %d
                )
                ",
			1,
			(int) $this->getId()
		)
	);
    }

    function getName()
    {
	$name = parent::getName();
        $this->setFitFromGlobalIfNoLocalFitment();
	if (!$this->rewritesOn() || !$this->fitsSelection())
	{
	    return $name;
	}
	$template = $this->getConfig()->seo->productNameTemplate;
	if (empty($template))
	{
	    $template = '_product_ for _vehicle_';
	}

	$find = array('_product_', '_vehicle_');
	$replace = array($name, (string) $this->currentlySelectedFit()->getFirstVehicle());
	return str_replace($find, $replace, $template);
    }
    
    function setFitFromGlobalIfNoLocalFitment()
    {
        $selection = Elite_Vaf_Helper_Data::getInstance()->vehicleSelection();
	if (!$this->fit && !$selection->isEmpty())
	{
	    $this->fit = $selection;
	}
    }

    function rewritesOn()
    {
	return $this->getConfig()->seo->rewriteProductName;
    }

    function globalRewritesOn()
    {
	return $this->getConfig()->seo->globalRewrites;
    }

    function setCurrentlySelectedFit($fit)
    {
	$this->fit = new Elite_Vaf_Model_Vehicle_Selection(array($fit));
    }

    function currentlySelectedFit()
    {
        $this->setFitFromGlobalIfNoLocalFitment();
        if($this->fit)
        {
            return $this->fit;
        }
        else
        {
            return new Elite_Vaf_Model_Vehicle_Selection();
        }
    }

    function fitsSelection()
    {
	$currentVehicleSelection = $this->currentlySelectedFit();
        if ($currentVehicleSelection->isEmpty())
	{
	    return false;
	}
        $vehicle = $currentVehicleSelection->getFirstVehicle();
        return $this->fitsVehicle($vehicle);
    }

    function fitsVehicle($vehicle)
    {
	$select = $this->getReadAdapter()->select()
			->from('elite_mapping', array('count(*)'))
			->where('entity_id = ?', $this->getId());
	$params = $vehicle->toValueArray();
        foreach ($params as $param => $value)
	{
	    $select->where($param .= '_id = ?', $value);
	}

	$count = $select->query()->fetchColumn();
	return 0 != $count;
    }

    function isInEnabledCategory(Elite_Vaf_Model_Catalog_Category_Filter $filter)
    {
	foreach ($this->getCategoryIds() as $categoryId)
	{
	    if ($filter->shouldShow($categoryId))
	    {
		return true;
	    }
	}
	return false;
    }

    function getMappingId(Elite_Vaf_Model_Vehicle $vehicle)
    {
	$schema = new Elite_Vaf_Model_Schema;
	$select = $this->getReadAdapter()->select()
			->from('elite_mapping', 'id')
			->where($schema->getLeafLevel() . '_id = ?', $vehicle->getLeafValue())
			->where('entity_id = ?', $this->getId());
	return $select->query()->fetchColumn();
    }

    /**
     * Create duplicate
     *
     * @return Mage_Catalog_Model_Product
     */
    function duplicate()
    {
	$schema = new Elite_Vaf_Model_Schema();
	$vehicleFinder = new Elite_Vaf_Model_Vehicle_Finder($schema);
	$leaf = $schema->getLeafLevel() . '_id';

	$newProduct = parent::duplicate();
	foreach ($this->getFits() as $fit)
	{
	    $vehicle = $vehicleFinder->findByLeaf($fit->$leaf);
	    $newProduct->insertMapping($vehicle);
	}
	if($this->isUniversal())
	{
	    $newProduct->setUniversal(true);
	}
	return $newProduct;
    }

    protected function findDefinitionByLeafId($leaf_id)
    {
	$finder = new Elite_Vaf_Model_Vehicle_Finder(new Elite_Vaf_Model_Schema);
	return $finder->findByLeaf($leaf_id);
    }

    /**
     * @param Elite_Vaf_Model_Abstract - if is an "aggregrate" of fits ( iterate and add it's children )
     */
    function doAddFit($entity)
    {

	$vehicleFinder = new Elite_Vaf_Model_Vehicle_Finder(new Elite_Vaf_Model_Schema);
	$params = array($entity->getType() => $entity->getTitle());
	$vehicles = $vehicleFinder->findByLevels($params);
	return $vehicles;
    }

    protected function createFitFromRow($row)
    {
	$schema = new Elite_Vaf_Model_Schema();
	return new Elite_Vaf_Model_Vehicle($schema, $row->id, $row);
    }

    protected function doGetFits($productId)
    {
	$select = new Elite_Vaf_Select($this->getReadAdapter());
	$select->from('elite_mapping')
		->addLevelTitles()
		->where('entity_id=?', $productId);
	$result = $this->query($select);

	$fits = array();
	while ($row = $result->fetchObject())
	{
	    if ($row->universal)
	    {
		continue;
	    }
	    $fits[] = $row;
	}
	return $fits;
    }

    function getSchema()
    {
	return new Elite_Vaf_Model_Schema();
    }

    /** @return Zend_Db_Statement_Interface */
    protected function query($sql)
    {
	return $this->getReadAdapter()->query($sql);
    }

    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
	return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }

}
