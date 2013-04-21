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
class Elite_Vaftire_Model_Catalog_Product_Import extends VF_Import_Abstract
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