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

class Elite_Vafdiagram_Model_Catalog_ProductTest extends Elite_Vafdiagram_Model_TestCase
{

    function doSetUp()
    {
	$this->switchSchema('make,model,year');
    }

    function testShouldAddSingleServiceCode()
    {
	$product = $this->newProduct(1);
	$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
	$product->addServiceCode(123);
	$this->assertEquals(array(123), $product->serviceCodes(), 'should add single service code for product');
    }

    function testShouldAddSingleServiceCode_WithPrefixingZero()
    {
	$product = $this->newProduct(1);
	$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
	$product->addServiceCode('00123');
	$this->assertEquals(array('00123'), $product->serviceCodes(), 'should add single service code for product (with prefixing zero');
    }

    function testShouldAddMultipleServiceCode()
    {
	$product = $this->newProduct(1);
	$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
	$product->addServiceCode(123);
	$product->addServiceCode(456);
	$this->assertEquals(array(123, 456), $product->serviceCodes(), 'should add multiple service codes for product');
    }

    function testShouldPersistServiceCodes()
    {
	$product = $this->newProduct(1);
	$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
	$product->addServiceCode(123);

	$product = $this->newProduct(1);
	$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
	$this->assertEquals(array(123), $product->serviceCodes(), 'should persist service codes for product');
    }

    function testShouldFilterServiceCodesByCategory1()
    {
	$product = $this->newProduct(1);
	$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
	$product->addServiceCode(123, array(
	    'category1' => 1
	));
	$product->addServiceCode(456, array(
	    'category1' => 2
	));
	$actual = $product->serviceCodes(array(
		    'category1' => 1
		));
	$this->assertEquals(array(123), $actual, 'should filter service codes by category 1');
    }

    function testShouldFilterServiceCodesByCategory2()
    {
	$product = $this->newProduct(1);
	$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
	$product->addServiceCode(123, array(
	    'category1' => 1,
	    'category2' => 1
	));
	$product->addServiceCode(456, array(
	    'category1' => 1,
	    'category2' => 2
	));
	$actual = $product->serviceCodes(array(
		    'category1' => 1,
		    'category2' => 2,
		));
	$this->assertEquals(array(456), $actual, 'should filter service codes by category 2');
    }

    function testShouldFilterServiceCodesByCategory3()
    {
	$product = $this->newProduct(1);
	$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
	$product->addServiceCode(123, array(
	    'category1' => 1,
	    'category2' => 1,
	    'category3' => 1
	));
	$product->addServiceCode(456, array(
	    'category1' => 1,
	    'category2' => 1,
	    'category3' => 2
	));
	$actual = $product->serviceCodes(array(
		    'category1' => 1,
		    'category2' => 1,
		    'category3' => 2
		));
	$this->assertEquals(array(456), $actual, 'should filter service codes by category 3');
    }

    function testShouldFilterServiceCodesByCategory4()
    {
	$product = $this->newProduct(1);
	$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
	$product->addServiceCode(123, array(
	    'category1' => 1,
	    'category2' => 1,
	    'category3' => 1,
	    'category4' => 1,
	));
	$product->addServiceCode(456, array(
	    'category1' => 1,
	    'category2' => 1,
	    'category3' => 1,
	    'category4' => 2,
	));
	$actual = $product->serviceCodes(array(
		    'category1' => 1,
		    'category2' => 1,
		    'category3' => 1,
		    'category4' => 2
		));
	$this->assertEquals(array(456), $actual, 'should filter service codes by category 4');
    }

    function testShouldAssociateCallout()
    {
	$product = $this->newProduct(1);
	$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
	$product->addServiceCode(123, array(
	    'category1' => 1,
	    'callout' => 1
	));
	$actual = $product->callout(array(
		    'category1' => 1
		));
	$this->assertEquals(1, $actual, 'should associate callout category 1');
    }

    function testShouldFilterCalloutByServiceCode()
    {
	$product = $this->newProduct(1);
	$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
	$product->addServiceCode(123, array(
	    'category1' => 1,
	    'callout' => 1
	));
	$product->addServiceCode(345, array(
	    'category1' => 1,
	    'callout' => 2
	));
	$actual = $product->callout(array(
		    'service_code' => 345,
		    'category1' => 1
		));
	$this->assertEquals(2, $actual, 'should associate calloutwith service code');
    }

    function testShouldAddIllustrationID()
    {
	$product = $this->newProduct(1);
	$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
	$product->addServiceCode(123, array(
	    'category1' => 1,
	    'illustration_id' => 1234
	));
	$product->addServiceCode(456, array(
	    'category1' => 2,
	    'illustration_id' => 4567
	));

	$actual = $product->illustrationID(array(
		    'category1' => 1,
		    'service_code' => 123
		));
	$this->assertEquals(1234, $actual, 'should add illustration ID');
    }

    function testShouldAddIllustrationID_WithPrefixingZeros()
    {
	$product = $this->newProduct(1);
	$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
	$product->addServiceCode('0123', array(
	    'category1' => 1,
	    'illustration_id' => '001234'
	));
	$product->addServiceCode(456, array(
	    'category1' => 2,
	    'illustration_id' => 4567
	));

	$actual = $product->illustrationID(array(
		    'category1' => 1,
		    'service_code' => '0123'
		));
	$this->assertSame('001234', $actual, 'should add illustration ID (with prefixing zeros)');
    }

}