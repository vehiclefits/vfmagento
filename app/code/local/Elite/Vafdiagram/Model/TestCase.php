<?php

abstract class Elite_Vafdiagram_Model_TestCase extends Elite_Vaf_TestCase
{

    function import($data)
    {
	$file = TESTFILES . '/mappings.csv';
	file_put_contents($file, $data);
	$import = new Elite_Vafdiagram_Model_ProductFitments_CSV_Import_TestSubClass($file);
	$import->import();
    }

    function importProductServiceCodes($data)
    {
	$file = TESTFILES . '/servicecodes.csv';
	file_put_contents($file, $data);
	$importer = new Elite_Vafdiagram_Model_ProductServiceCodeImporter_TestSubClass($file);
	$importer->import();
    }

    function product($id)
    {
	$product = new Elite_Vaf_Model_Catalog_Product;
	$product->setId($id);
	$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
	return $product;
    }

}

class Elite_Vafdiagram_Model_ProductServiceCodeImporter_TestSubClass extends Elite_Vafdiagram_Model_ProductServiceCodeImporter
{

    function getProductTable()
    {
	return 'test_catalog_product_entity';
    }

}

class Elite_Vafdiagram_Model_ProductFitments_CSV_Import_TestSubClass extends Elite_Vafdiagram_Model_ProductFitments_CSV_Import
{

    function getProductTable()
    {
	return 'test_catalog_product_entity';
    }

}