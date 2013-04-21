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
class Elite_Vafdiagram_Model_CategoryFinderTest extends Elite_Vafdiagram_Model_TestCase
{
	
	function testShouldFilterByProduct_Level1()
	{
		$productId1 = $this->insertProduct('sku1');
		$productId2 = $this->insertProduct('sku2');
		
		$this->importProductServiceCodes('sku,category1,category2,category3,category4,illustration_id,service_code' . "\n" .
										 'sku1,5,2,3,4,1234,123' . "\n" . 
										 'sku2,6,2,3,5,4567,456');		
		
		$finder = new Elite_Vafdiagram_Model_CategoryFinder;
		
		$actual = $finder->listCategories(array(
			'product'=>$productId1
		));
		$this->assertEquals( array(5), $actual, 'should filter categories by product');
	}
	
	function testShouldListForRightLevel()
	{
		$productId1 = $this->insertProduct('sku1');
		$productId2 = $this->insertProduct('sku2');
		
		$this->importProductServiceCodes('sku,category1,category2,category3,category4,illustration_id,service_code' . "\n" .
										 'sku1,5,2,3,4,1234,123' . "\n" . 
										 'sku2,6,2,3,5,4567,456');		
		
		$finder = new Elite_Vafdiagram_Model_CategoryFinder;
		
		$actual = $finder->listCategories(array(
			'product'=>$productId1,
			'level1' => 0,
			'level2' => 0,
			'level3' => 0,
			'level4' => 0,
		));
		$this->assertEquals( array(5), $actual, 'should list for right level');
	}
	
	function testShouldListDistinct()
	{
		$productId1 = $this->insertProduct('sku1');
		$productId2 = $this->insertProduct('sku2');
		
		$this->importProductServiceCodes('sku,category1,category2,category3,category4,illustration_id,service_code' . "\n" .
										 'sku1,5,2,3,4,1234,123' . "\n" . 
										 'sku2,5,2,3,5,4567,123');		
		
		$finder = new Elite_Vafdiagram_Model_CategoryFinder;
		
		$actual = $finder->listCategories(array(
			'level1' => 0,
			'level2' => 0,
			'level3' => 0,
			'level4' => 0,
		));
		$this->assertEquals( array(5), $actual, 'should list distinct');
	}
	
	function testShouldFilterByServiceCode_Level1()
	{
		$productId1 = $this->insertProduct('sku1');
		
		$this->importProductServiceCodes('sku,category1,category2,category3,category4,illustration_id,service_code' . "\n" .
										 'sku1,5,2,3,4,1234,123' . "\n" . 
										 'sku1,6,2,3,5,4567,456');		
		
		$finder = new Elite_Vafdiagram_Model_CategoryFinder;
		
		$actual = $finder->listCategories(array(
			'service_code'=>123
		));
		$this->assertEquals( array(5), $actual, 'should filter categories by service code');
	}
	
	function testShouldFilterByProduct_Level2()
	{
		$productId1 = $this->insertProduct('sku1');
		$productId2 = $this->insertProduct('sku2');
		
		$this->importProductServiceCodes('sku,category1,category2,category3,category4,illustration_id,service_code' . "\n" .
										 'sku1,5,2,3,4,1234,123' . "\n" . 
										 'sku2,5,3,3,5,4567,456');		
		
		$finder = new Elite_Vafdiagram_Model_CategoryFinder;
		
		$actual = $finder->listCategories(array(
			'product'=>$productId1,
			'level1'=>5
		));
		$this->assertEquals( array(2), $actual, 'should filter categories by product');
	}
	
	function testShouldFilterByServiceCode_Level2()
	{
		$productId1 = $this->insertProduct('sku1');
		
		$this->importProductServiceCodes('sku,category1,category2,category3,category4,illustration_id,service_code' . "\n" .
										 'sku1,5,2,3,4,1234,123' . "\n" . 
										 'sku1,5,3,3,5,4567,456');		
		
		$finder = new Elite_Vafdiagram_Model_CategoryFinder;
		
		$actual = $finder->listCategories(array(
			'level1' => 5,
			'product'=>$productId1,
			'service_code'=>123
		));
		$this->assertEquals( array(2), $actual, 'should filter categories by service code');
	}
	
	function testShouldFilterByLevel1_Level2()
	{
		$productId1 = $this->insertProduct('sku1');
		
		$this->importProductServiceCodes('sku,category1,category2,category3,category4,illustration_id,service_code' . "\n" .
										 'sku1,5,2,3,4,1234,123' . "\n" . 
										 'sku1,6,3,3,5,1234,1234');		
		
		$finder = new Elite_Vafdiagram_Model_CategoryFinder;
		
		$actual = $finder->listCategories(array(
			'level1' => 5,
			'product'=>$productId1,
		));
		$this->assertEquals( array(2), $actual, 'should filter categories by category level1');
	}

}