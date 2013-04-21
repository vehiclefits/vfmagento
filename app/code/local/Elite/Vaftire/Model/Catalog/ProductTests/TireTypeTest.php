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
class Elite_Vaftire_Model_Catalog_ProductTests_TireTypeTest extends Elite_Vaf_TestCase
{
	function testNoTireType()
	{
		$this->assertFalse( $this->newTireProduct(1)->tireType(), 'should have no tire type' );
	}
	
	function testSetToWinter()
	{
		$product = $this->newTireProduct(1);
		$product->setTireType( Elite_Vaftire_Model_Catalog_Product::WINTER );
		$this->assertEquals( Elite_Vaftire_Model_Catalog_Product::WINTER, $this->newTireProduct(1)->tireType(), 'should set tire type' );
	}
	
	function testSetToSummer()
	{
		$product = $this->newTireProduct(1);
		$product->setTireType( Elite_Vaftire_Model_Catalog_Product::SUMMER_ALL );
		$this->assertEquals( Elite_Vaftire_Model_Catalog_Product::SUMMER_ALL, $this->newTireProduct(1)->tireType(), 'should set tire type' );
	}
	
	function testSetAndUnset()
	{
		$product = $this->newTireProduct(1);
		$product->setTireType( Elite_Vaftire_Model_Catalog_Product::WINTER );
		$product->setTireType(false);
		$this->assertFalse( $this->newTireProduct(1)->tireType(), 'should set & unset tire type' );
	}
	
	function testDoesntInterfereWithTireSize()
	{
		$product = $this->newTireProduct(1);
		$product->setTireSize( new Elite_Vaftire_Model_TireSize(205,55,16) );
		$product->setTireType( Elite_Vaftire_Model_Catalog_Product::WINTER );
		$product->setTireSize( false );
		$this->assertFalse( $this->newTireProduct(1)->tireType(), 'should set & unset tire type' );
	}
}