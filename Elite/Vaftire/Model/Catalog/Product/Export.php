<?php

class Elite_Vaftire_Model_Catalog_Product_Export
{

    function export()
    {
	$csv = '"sku","section_width","aspect_ratio","diameter"';
	$csv .= "\n";

	foreach ($this->getProductRows() as $productRow)
	{
	    $product = new Elite_Vaf_Model_Catalog_Product;
	    $product->setId($productRow['entity_id']);
	    
	    $product = new Elite_Vaftire_Model_Catalog_Product($product);
	    if ($product->getTireSize())
	    {
		$tireSize = $product->getTireSize();

		$csv .= '"' . $productRow['sku'] . '",';
		$csv .= '"' . $tireSize->sectionWidth() . '",';
		$csv .= '"' . $tireSize->aspectRatio() . '",';
		$csv .= '"' . $tireSize->diameter() . '"';
		$csv .= "\n";
	    }
	}

	return $csv;
    }

    function getProductRows()
    {
	$query = Elite_Vaf_Helper_Data::getInstance()->getReadAdapter()->select()
		->from($this->getProductTable(), array('entity_id','sku'));
	$rs = $query->query();
	$ids = array();
	while($productRow = $rs->fetch())
	{
	    array_push($ids, $productRow);
	}
	return $ids;
    }

    function getProductTable()
    {
        $resource = new Mage_Catalog_Model_Resource_Eav_Mysql4_Product;
        $table = $resource->getTable( 'catalog/product' );
        return $table;
    }

}