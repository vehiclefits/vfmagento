<?php
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
		$this->assertEquals( array(123), $product->serviceCodes(), 'should add single service code for product');
	}
	
	function testShouldAddMultipleServiceCode()
	{
		$product = $this->newProduct(1);
		$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
		$product->addServiceCode(123);
		$product->addServiceCode(456);
		$this->assertEquals( array(123,456), $product->serviceCodes(), 'should add multiple service codes for product');
	}
	
	function testShouldPersistServiceCodes()
	{
		$product = $this->newProduct(1);
		$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
		$product->addServiceCode(123);
		
		$product = $this->newProduct(1);
		$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
		$this->assertEquals( array(123), $product->serviceCodes(), 'should persist service codes for product');
	}
	
	function testShouldFilterServiceCodesByCategory1()
	{
		$product = $this->newProduct(1);
		$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
		$product->addServiceCode(123, 1);
		$product->addServiceCode(456, 2);
		$this->assertEquals( array(123), $product->serviceCodes(1), 'should filter service codes by category 1');
	}
	
	function testShouldFilterServiceCodesByCategory2()
	{
		return $this->markTestIncomplete();
	}
	
	function testShouldFilterServiceCodesByCategory3()
	{
		return $this->markTestIncomplete();
	}
	
	function testShouldFilterServiceCodesByCategory4()
	{
		return $this->markTestIncomplete();
	}
	
	function testShouldAddIllustrationID()
	{
		$product = $this->newProduct(1);
		$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
		$product->addServiceCode(123, 1, null, null, null, 1234);
		$product->addServiceCode(456, 2, null, null, null, 4567);
		
		$actual = $product->illustrationID(array(
			'category1'=>1,
			'service_code'=>123
		));
		$this->assertEquals( 1234, $actual, 'should add illustration ID');
	}
}