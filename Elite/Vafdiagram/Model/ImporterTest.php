<?php
class Elite_Vafdiagram_Model_ImporterTest extends Elite_Vaf_TestCase
{
	function testShouldAddSingleServiceCode()
	{
		$product = $this->newProduct(1);
		$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
		$product->addServiceCode(123);
		$this->assertEquals( array(123), $product->serviceCodes(), 'should add single service code');
	}
	
	function testShouldAddMultipleServiceCode()
	{
		$product = $this->newProduct(1);
		$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
		$product->addServiceCode(123);
		$product->addServiceCode(456);
		$this->assertEquals( array(123,456), $product->serviceCodes(), 'should add multiple service codes');
	}
	
	function testShouldSaveServiceCodes()
	{
		$product = $this->newProduct(1);
		$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
		$product->addServiceCode(123);
		
		$product = $this->newProduct(1);
		$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
		$this->assertEquals( array(123), $product->serviceCodes(), 'should add multiple service codes');
	}
}