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

class Elite_Vafdiagram_Model_ProductFinderTest extends Elite_Vafdiagram_Model_TestCase
{

    function testShouldFilterProductsByCategory1()
    {
	$productId1 = $this->insertProduct('sku1');
	$productId2 = $this->insertProduct('sku2');

	$this->importProductServiceCodes('sku,category1,illustration_id,service_code' . "\n" .
		'sku1,1,1234,123' . "\n" .
		'sku2,2,4567,456');

	$finder = new Elite_Vafdiagram_Model_ProductFinder;

	$actual = $finder->listProductIds(array(
		    'category1' => 1
		));
	$this->assertEquals(array($productId1), $actual, 'should filter by category1');
    }

    function testShouldFilterProductsByCategory2()
    {
	$productId1 = $this->insertProduct('sku1');
	$productId2 = $this->insertProduct('sku2');

	$this->importProductServiceCodes('sku,category1,category2,illustration_id,service_code' . "\n" .
		'sku1,1,1,1234,123' . "\n" .
		'sku2,1,2,4567,456');

	$finder = new Elite_Vafdiagram_Model_ProductFinder;
	$actual = $finder->listProductIds(array(
		    'category1' => 1,
		    'category2' => 1,
		));
	$this->assertEquals(array($productId1), $actual, 'should filter by category2');
    }

    function testShouldFilterProductsByCategory3()
    {
	$productId1 = $this->insertProduct('sku1');
	$productId2 = $this->insertProduct('sku2');

	$this->importProductServiceCodes('sku,category1,category2,category3,illustration_id,service_code' . "\n" .
		'sku1,1,1,1,1234,123' . "\n" .
		'sku2,1,1,2,4567,456');

	$finder = new Elite_Vafdiagram_Model_ProductFinder;
	$actual = $finder->listProductIds(array(
		    'category1' => 1,
		    'category2' => 1,
		    'category3' => 1,
		));
	$this->assertEquals(array($productId1), $actual, 'should filter by category3');
    }

    function testShouldFilterProductsByCategory4()
    {
	$productId1 = $this->insertProduct('sku1');
	$productId2 = $this->insertProduct('sku2');

	$this->importProductServiceCodes('sku,category1,category2,category3,category4,illustration_id,service_code' . "\n" .
		'sku1,1,1,1,1,1234,123' . "\n" .
		'sku2,1,1,1,2,4567,456');

	$finder = new Elite_Vafdiagram_Model_ProductFinder;
	$actual = $finder->listProductIds(array(
		    'category1' => 1,
		    'category2' => 1,
		    'category3' => 1,
		    'category4' => 1,
		));
	$this->assertEquals(array($productId1), $actual, 'should filter by category4');
    }

    function testShouldFilterProductsByServiceCode()
    {
	$productId1 = $this->insertProduct('sku1');
	$productId2 = $this->insertProduct('sku2');

	$this->importProductServiceCodes('sku,category1,category2,category3,category4,illustration_id,service_code' . "\n" .
		'sku1,1,1,1,1,1234,123' . "\n" .
		'sku2,1,1,1,1,4567,456');

	$finder = new Elite_Vafdiagram_Model_ProductFinder;
	$actual = $finder->listProductIds(array(
		    'category1' => 1,
		    'category2' => 1,
		    'category3' => 1,
		    'category4' => 1,
		    'service_code' => 123,
		));
	$this->assertEquals(array($productId1), $actual, 'should list products');
    }

    function testShouldFilterIllustrationIdsByCategory1()
    {
	$productId1 = $this->insertProduct('sku1');
	$productId2 = $this->insertProduct('sku2');
	$productId3 = $this->insertProduct('sku3');

	$this->importProductServiceCodes('sku,category1,illustration_id,service_code' . "\n" .
		'sku1,1,1234,123' . "\n" .
		'sku2,1,4567,456' . "\n" .
		'sku3,2,2345,456');

	$finder = new Elite_Vafdiagram_Model_ProductFinder;

	$actual = $finder->listIllustrationIds(array(
		    'category1' => 1
		));
	$this->assertEquals(array(1234,4567), $actual, 'should filter by category1');
    }

    function testShouldListDistinctIllustrationIds()
    {
	$productId1 = $this->insertProduct('sku1');
	$productId2 = $this->insertProduct('sku2');
	$productId3 = $this->insertProduct('sku3');

	$this->importProductServiceCodes('sku,category1,illustration_id,service_code' . "\n" .
		'sku1,1,1234,123' . "\n" .
		'sku2,1,1234,456' . "\n");

	$finder = new Elite_Vafdiagram_Model_ProductFinder;

	$actual = $finder->listIllustrationIds(array(
		    'category1' => 1
		));
	$this->assertEquals(array(1234), $actual, 'should list distinct illustration IDs');
    }

}