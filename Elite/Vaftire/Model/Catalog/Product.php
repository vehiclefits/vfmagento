<?php

class Elite_Vaftire_Model_Catalog_Product
{

    /** @var Elite_Vaf_Model_Catalog_Product */
    protected $wrappedProduct;

    const SUMMER_ALL = 1;
    const WINTER = 2;

    function __construct(Elite_Vaf_Model_Catalog_Product $productToWrap)
    {
	$this->wrappedProduct = $productToWrap;
    }

    /** @param mixed boolean false for none, or Elite_Vaftire_Model_TireSize */
    function setTireSize($tireSize)
    {
	if (false === $tireSize)
	{
	    $sql = sprintf("DELETE FROM `elite_product_tire` WHERE `entity_id` = %d", $this->getId());
	    return $this->query($sql);
	}
	$sql = sprintf(
			"INSERT INTO `elite_product_tire` ( `entity_id`, `section_width`, `aspect_ratio`, `diameter` ) VALUES ( %d, %d, %d, %d )
            ON DUPLICATE KEY UPDATE `section_width` = VALUES(`section_width`), `aspect_ratio` = VALUES(`aspect_ratio`), `diameter` = VALUES(`diameter`) ",
			$this->getId(),
			(int) $tireSize->sectionWidth(),
			(int) $tireSize->aspectRatio(),
			(int) $tireSize->diameter()
	);
	$this->query($sql);
	$this->doBindTireVehicles($tireSize);
    }

    function doBindTireVehicles($tireSize)
    {
	if (!$this->getId() || !$tireSize->sectionWidth() || !$tireSize->diameter() || !$tireSize->aspectRatio())
	{
	    return;
	}
	$select = $this->getReadAdapter()->select()
			->from('elite_vehicle_tire')
			->where('section_width = ?', $tireSize->sectionWidth())
			->where('diameter = ?', $tireSize->diameter())
			->where('aspect_ratio = ?', $tireSize->aspectRatio());

	$result = $select->query();
	foreach ($result->fetchAll() as $vehicleRow)
	{
	    $vehicle = $this->vehicle($vehicleRow['leaf_id']);
	    $this->addVafFit($vehicle->toValueArray());
	}
    }

    function vehicle($leafId)
    {
	$vehicleFinder = new Elite_Vaf_Model_Vehicle_Finder(new VF_Schema());
	return $vehicleFinder->findByLeaf($leafId);
    }

    /** @return Elite_Vaftire_Model_TireSize */
    function getTireSize()
    {
	if(!$this->getId())
	{
	    return false;
	}
	$select = $this->getReadAdapter()->select()
			->from('elite_product_tire')
			->where('entity_id=?', $this->getId());

	$result = $select->query();
	$row = $result->fetchObject();
	if (!$row || (!$row->section_width && !$row->aspect_ratio && !$row->diameter))
	{
	    return false;
	}

	$tireSize = new Elite_Vaftire_Model_TireSize($row->section_width, $row->aspect_ratio, $row->diameter);
	return $tireSize;
    }

    function tireType()
    {
	if(!$this->getId())
	{
	    return false;
	}
	$select = $this->getReadAdapter()->select()
			->from('elite_product_tire')
			->where('entity_id=?', $this->getId());
	$result = $select->query();
	$row = $result->fetchObject();
	if (!$row || !$row->tire_type)
	{
	    return false;
	}
	return $row->tire_type;
    }

    function setTireType($tireType)
    {
	$sql = sprintf(
			"INSERT INTO `elite_product_tire` ( `entity_id`, `tire_type` ) VALUES ( %d, %d )
            ON DUPLICATE KEY UPDATE `tire_type` = VALUES(`tire_type`)",
			$this->getId(),
			(int) $tireType
	);
	$this->query($sql);
    }

    function __call($methodName, $arguments)
    {
	$method = array($this->wrappedProduct, $methodName);
	return call_user_func_array($method, $arguments);
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