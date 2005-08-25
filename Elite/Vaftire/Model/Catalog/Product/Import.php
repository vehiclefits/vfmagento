<?php
class Elite_Vaftire_Model_Catalog_Product_Import extends VafVehicle_Import_Abstract
{
	function import()
	{
		$this->getFieldPositions();
        while( $row = $this->getReader()->getRow() )
        {
            $this->importRow($row);
        }
	}
	
	function importRow($row)
	{
		$sku = $this->getFieldValue('sku',$row);
		$productId = $this->productId($sku);
		
		$product = new Elite_Vaftire_Model_Catalog_Product(new Elite_Vaf_Model_Catalog_Product());
		$product->setId($productId);
		
        $tireSize = $this->tireSize($row);
		$product->setTireSize($tireSize);
		$product->setTireType($this->tireType($row));
        
        $this->log( sprintf('Assigned tire size [%s] to sku [%s]', $tireSize, $sku ) );
	}
	
	function tireSize($row)
	{
		$section_width = $this->getFieldValue('section_width',$row);
		$aspect_ratio = $this->getFieldValue('aspect_ratio',$row);
		$diameter = $this->getFieldValue('diameter',$row);
		return new Elite_Vaftire_Model_TireSize($section_width,$aspect_ratio,$diameter);
	}
	
	function tireType($row)
	{
		return $this->getFieldValue('tire_type',$row);
	}
}