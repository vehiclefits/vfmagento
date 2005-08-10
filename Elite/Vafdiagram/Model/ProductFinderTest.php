<?php 
class Elite_Vafdiagram_Model_ProductFinderTest extends Elite_Vafdiagram_Model_TestCase
{
	function testShouldFilterByCategory1()
	{
		$productId1 = $this->insertProduct('sku1');
		$productId2 = $this->insertProduct('sku2');
		
		$this->importProductServiceCodes('sku,category1,illustration_id,service_code' . "\n" .
										 'sku1,1,1234,123' . "\n" . 
										 'sku2,2,4567,456');		
		
		$finder = new Elite_Vafdiagram_Model_ProductFinder;
		
		$actual = $finder->listProductIds(array(
			'category1'=>1
		));
		$this->assertEquals( array($productId1), $actual, 'should filter by category1');
	}
	
	function testShouldFilterByCategory2()
	{
		$productId1 = $this->insertProduct('sku1');
		$productId2 = $this->insertProduct('sku2');
		
		$this->importProductServiceCodes('sku,category1,category2,illustration_id,service_code' . "\n" .
										 'sku1,1,1,1234,123' . "\n" . 
										 'sku2,1,2,4567,456');		
		
		$finder = new Elite_Vafdiagram_Model_ProductFinder;
		$actual = $finder->listProductIds(array(
			'category1'=>1,
			'category2'=>1,
		));
		$this->assertEquals( array($productId1), $actual, 'should filter by category2');		
	}
	
	function testShouldFilterByCategory3()
	{
		$productId1 = $this->insertProduct('sku1');
		$productId2 = $this->insertProduct('sku2');
		
		$this->importProductServiceCodes('sku,category1,category2,category3,illustration_id,service_code' . "\n" .
										 'sku1,1,1,1,1234,123' . "\n" . 
										 'sku2,1,1,2,4567,456');		
		
		$finder = new Elite_Vafdiagram_Model_ProductFinder;
		$actual = $finder->listProductIds(array(
			'category1'=>1,
			'category2'=>1,
			'category3'=>1,
		));
		$this->assertEquals( array($productId1), $actual, 'should filter by category3');		
	}	
	
	function testShouldFilterByCategory4()
	{
		$productId1 = $this->insertProduct('sku1');
		$productId2 = $this->insertProduct('sku2');
		
		$this->importProductServiceCodes('sku,category1,category2,category3,category4,illustration_id,service_code' . "\n" .
										 'sku1,1,1,1,1,1234,123' . "\n" . 
										 'sku2,1,1,1,2,4567,456');		
		
		$finder = new Elite_Vafdiagram_Model_ProductFinder;
		$actual = $finder->listProductIds(array(
			'category1'=>1,
			'category2'=>1,
			'category3'=>1,
			'category4'=>1,
		));
		$this->assertEquals( array($productId1), $actual, 'should filter by category4');		
	}
	
	function testShouldFilterByServiceCode()
	{
		$productId1 = $this->insertProduct('sku1');
		$productId2 = $this->insertProduct('sku2');
		
		$this->importProductServiceCodes('sku,category1,category2,category3,category4,illustration_id,service_code' . "\n" .
										 'sku1,1,1,1,1,1234,123' . "\n" . 
										 'sku2,1,1,1,1,4567,456');		
		
		$finder = new Elite_Vafdiagram_Model_ProductFinder;
		$actual = $finder->listProductIds(array(
			'category1'=>1,
			'category2'=>1,
			'category3'=>1,
			'category4'=>1,
			'service_code'=>123,
		));
		$this->assertEquals( array($productId1), $actual, 'should list products');		
	}
}