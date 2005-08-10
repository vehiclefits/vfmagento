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
		$this->assertEquals( array($productId1), $finder->listProductIds(1), 'should list products');
	}
	
	function testShouldFilterByCategory2()
	{
		$productId1 = $this->insertProduct('sku1');
		$productId2 = $this->insertProduct('sku2');
		
		$this->importProductServiceCodes('sku,category1,category2,illustration_id,service_code' . "\n" .
										 'sku1,1,1,1234,123' . "\n" . 
										 'sku2,1,2,4567,456');		
		
		$finder = new Elite_Vafdiagram_Model_ProductFinder;
		$this->assertEquals( array($productId1), $finder->listProductIds(1,1), 'should list products');		
	}
	
	function testShouldFilterByCategory3()
	{
		$productId1 = $this->insertProduct('sku1');
		$productId2 = $this->insertProduct('sku2');
		
		$this->importProductServiceCodes('sku,category1,category2,category3,illustration_id,service_code' . "\n" .
										 'sku1,1,1,1,1234,123' . "\n" . 
										 'sku2,1,1,2,4567,456');		
		
		$finder = new Elite_Vafdiagram_Model_ProductFinder;
		$this->assertEquals( array($productId1), $finder->listProductIds(1,1,1), 'should list products');		
	}	
	
	function testShouldFilterByCategory4()
	{
		$productId1 = $this->insertProduct('sku1');
		$productId2 = $this->insertProduct('sku2');
		
		$this->importProductServiceCodes('sku,category1,category2,category3,category4,illustration_id,service_code' . "\n" .
										 'sku1,1,1,1,1,1234,123' . "\n" . 
										 'sku2,1,1,1,2,4567,456');		
		
		$finder = new Elite_Vafdiagram_Model_ProductFinder;
		$this->assertEquals( array($productId1), $finder->listProductIds(1,1,1,1), 'should list products');		
	}
	
	function testShouldFilterByServiceCode()
	{
		$productId1 = $this->insertProduct('sku1');
		$productId2 = $this->insertProduct('sku2');
		
		$this->importProductServiceCodes('sku,category1,category2,category3,category4,illustration_id,service_code' . "\n" .
										 'sku1,1,1,1,1,1234,123' . "\n" . 
										 'sku2,1,1,1,1,4567,456');		
		
		$finder = new Elite_Vafdiagram_Model_ProductFinder;
		$this->assertEquals( array($productId1), $finder->listProductIds(1,1,1,1,123), 'should list products');		
	}
}