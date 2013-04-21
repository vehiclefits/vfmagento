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
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Elite_Vafwheel_Model_Catalog_Product_Import extends VF_Import_Abstract
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