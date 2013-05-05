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

class Elite_Vafdiagram_Model_ProductServiceCodeImporter extends VF_Import_Abstract
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