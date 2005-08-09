<?php
class Elite_Vafdiagram_Model_ProductServiceCodeImporterTest extends Elite_Vafdiagram_Model_TestCase
{
	function doSetUp()
	{
		$this->switchSchema('make,model,year');
	}
	
	function testShouldAddSingleServiceCodeToProduct()
	{
		$product = $this->newProduct(1);
		$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
		$product->addServiceCode(123);
		$this->assertEquals( array(123), $product->serviceCodes(), 'should add single service code for product');
	}
	
	function testShouldFilterServiceCodesByCategory1()
	{
		$product = $this->newProduct(1);
		$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
		$product->addServiceCode(123, 1);
		$product->addServiceCode(456, 2);
		$this->assertEquals( array(123), $product->serviceCodes(1), 'should filter service codes by category 1');
	}
	
	function testShouldAddMultipleServiceCodeToProduct()
	{
		$product = $this->newProduct(1);
		$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
		$product->addServiceCode(123);
		$product->addServiceCode(456);
		$this->assertEquals( array(123,456), $product->serviceCodes(), 'should add multiple service codes for product');
	}
	
	function testShouldImportServiceCodesToProduct()
	{
		$productId = $this->insertProduct('sku1');
		
		$this->importProductServiceCodes('sku,service_code' . "\n" .
										 'sku1,123' . "\n" . 
										 'sku1,456');
		$product = $this->product($productId);		
		$this->assertEquals( array(123,456), $product->serviceCodes(), 'should import multiple service codes for product');
	}
	
	function testShouldAssociateCategory1WithProductServiceCode()
	{
		$productId = $this->insertProduct('sku1');
		
		$this->importProductServiceCodes('sku,category1,service_code' . "\n" .
										 'sku1,1,123' . "\n" . 
										 'sku1,2,456');
		$product = $this->product($productId);		
		$this->assertEquals( array(123), $product->serviceCodes(1), 'should assocaite category 1 with product service codes');
		$this->assertEquals( array(456), $product->serviceCodes(2), 'should assocaite category 1 with product service codes');
	}
	
	function testShouldAssociateCategory2WithProductServiceCode()
	{
		return $this->markTestIncomplete();
	}
	
	function testShouldAssociateCategory3WithProductServiceCode()
	{
		return $this->markTestIncomplete();
	}
	
	function testShouldAssociateCategory4WithProductServiceCode()
	{
		return $this->markTestIncomplete();
	}
	
	function testShouldPersistServiceCodesForProduct()
	{
		$product = $this->newProduct(1);
		$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
		$product->addServiceCode(123);
		
		$product = $this->newProduct(1);
		$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
		$this->assertEquals( array(123), $product->serviceCodes(), 'should persist service codes for product');
	}
}