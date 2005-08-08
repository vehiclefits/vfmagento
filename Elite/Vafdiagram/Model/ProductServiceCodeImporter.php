<?php
class Elite_Vafdiagram_Model_ProductServiceCodeImporter extends Ne8Vehicle_Import_Abstract
{
	function import()
	{
		$h = fopen($this->file,'r');
		while($row=fgetcsv($h))
		{
			$sku = $this->getFieldValue('sku',$row);						
			$service_code = $this->getFieldValue('service_code',$row);
			$product = $this->product($sku);
			$product->addServiceCode($service_code);
		}
	}
	
	function product($sku)
	{
		$product = new Elite_Vaf_Model_Catalog_Product;
		$product->setId($this->productId($sku));
		$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
		return $product;
	}
}