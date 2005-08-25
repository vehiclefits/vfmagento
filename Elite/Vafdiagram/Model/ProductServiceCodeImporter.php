<?php

class Elite_Vafdiagram_Model_ProductServiceCodeImporter extends VafVehicle_Import_Abstract
{

    function import()
    {
	$h = fopen($this->file, 'r');
	while ($row = fgetcsv($h))
	{
	    $sku = $this->getFieldValue('sku', $row);
	    $service_code = $this->getFieldValue('service_code', $row);
	    $category1 = $this->getFieldValue('category1', $row);
	    $category2 = $this->getFieldValue('category2', $row);
	    $category3 = $this->getFieldValue('category3', $row);
	    $category4 = $this->getFieldValue('category4', $row);
	    $illustration_id = $this->getFieldValue('illustration_id', $row);
	    $callout = $this->getFieldValue('callout', $row);
	    $product = $this->product($sku);
	    if(!$product->getId())
	    {
		continue;
	    }
	    $product->addServiceCode($service_code, array(
		'category1' => $category1,
		'category2' => $category2,
		'category3' => $category3,
		'category4' => $category4,
		'illustration_id' => $illustration_id,
		'callout' => $callout
	    ));
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