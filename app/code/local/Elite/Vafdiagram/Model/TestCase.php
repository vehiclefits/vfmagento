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
 * to sales@vehiclefits.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

abstract class Elite_Vafdiagram_Model_TestCase extends VF_TestCase
{

    function import($data)
    {
	$file = TEMP_PATH . '/mappings.csv';
	file_put_contents($file, $data);
	$import = new Elite_Vafdiagram_Model_ProductFitments_CSV_Import_TestSubClass($file);
	$import->import();
    }

    function importProductServiceCodes($data)
    {
	$file = TEMP_PATH . '/servicecodes.csv';
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