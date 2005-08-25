<?php

class Elite_Vafwheel_Model_Catalog_Product_Import extends VafVehicle_Import_Abstract
{

    function import()
    {
	$this->getFieldPositions();
	while ($row = $this->getReader()->getRow())
	{
	    $this->importRow($row);
	}
    }

    function importRow($row)
    {
	$sku = $this->getFieldValue('sku', $row);
	$productId = $this->productId($sku);

	$product = new Elite_Vafwheel_Model_Catalog_Product(new Elite_Vaf_Model_Catalog_Product());
	$product->setId($productId);

	$boltPattern = $this->wheelSize($row);
	$product->addBoltPattern($boltPattern);
	
    }

    function wheelSize($row)
    {
	$lugCount = $this->getFieldValue('lug_count', $row);
	$boltDistance = $this->getFieldValue('bolt_distance', $row);
	$offset = $this->getFieldValue('offset', $row);
	
	return Elite_Vafwheel_Model_BoltPattern::create($lugCount.'x'.$boltDistance, $offset);
    }

    function tireType($row)
    {
	return $this->getFieldValue('tire_type', $row);
    }

}