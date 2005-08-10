<?php
class Elite_Vafdiagram_Model_ProductServiceCodeImporterTest extends Elite_Vafdiagram_Model_TestCase
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
		$this->assertEquals( 1234, $product->illustrationID(1, null, null, null, 123), 'should add illustration ID');
	}
	
	function testShouldImportServiceCodes()
	{
		$productId = $this->insertProduct('sku1');
		
		$this->importProductServiceCodes('sku,service_code' . "\n" .
										 'sku1,123' . "\n" . 
										 'sku1,456');
		$product = $this->product($productId);		
		$this->assertEquals( array(123,456), $product->serviceCodes(), 'should import multiple service codes for product');
	}
	
	function testShouldAssociateCategory1WithServiceCode()
	{
		$productId = $this->insertProduct('sku1');
		
		$this->importProductServiceCodes('sku,category1,service_code' . "\n" .
										 'sku1,1,123' . "\n" . 
										 'sku1,2,456');
		$product = $this->product($productId);		
		$this->assertEquals( array(123), $product->serviceCodes(1), 'should assocaite category 1 with product service codes');
		$this->assertEquals( array(456), $product->serviceCodes(2), 'should assocaite category 1 with product service codes');
	}
	
	function testShouldAssociateCategory2WithServiceCode()
	{
		$productId = $this->insertProduct('sku1');
		
		$this->importProductServiceCodes('sku,category1,category2,service_code' . "\n" .
										 'sku1,1,1,123' . "\n" . 
										 'sku1,1,2,456');
		$product = $this->product($productId);		
		$this->assertEquals( array(123), $product->serviceCodes(1,1), 'should assocaite category 2 with product service codes');
		$this->assertEquals( array(456), $product->serviceCodes(1,2), 'should assocaite category 2 with product service codes');
	}
	
	function testShouldAssociateCategory3WithServiceCode()
	{
		$productId = $this->insertProduct('sku1');
		
		$this->importProductServiceCodes('sku,category1,category2,category3,service_code' . "\n" .
										 'sku1,1,1,1,123' . "\n" . 
										 'sku1,1,1,2,456');
		$product = $this->product($productId);		
		$this->assertEquals( array(123), $product->serviceCodes(1,1,1), 'should assocaite category 3 with product service codes');
		$this->assertEquals( array(456), $product->serviceCodes(1,1,2), 'should assocaite category 3 with product service codes');
	}
	
	function testShouldAssociateCategory4WithServiceCode()
	{
		$productId = $this->insertProduct('sku1');
		
		$this->importProductServiceCodes('sku,category1,category2,category3,category4,service_code' . "\n" .
										 'sku1,1,1,1,1,123' . "\n" . 
										 'sku1,1,1,1,2,456');
		$product = $this->product($productId);		
		$this->assertEquals( array(123), $product->serviceCodes(1,1,1,1), 'should assocaite category 4 with product service codes');
		$this->assertEquals( array(456), $product->serviceCodes(1,1,1,2), 'should assocaite category 4 with product service codes');
	}
	
	function testShouldAssociateCategory1WithIllustration()
	{
		$productId = $this->insertProduct('sku1');
		
		$this->importProductServiceCodes('sku,category1,illustration_id,service_code' . "\n" .
										 'sku1,1,1234,123' . "\n" . 
										 'sku1,2,4567,456');
		$product = $this->product($productId);		
		$this->assertEquals( 1234, $product->illustrationId(1,null,null,null, 123), 'should lookup have correct illustration ID for category & service code combination');
	}
	
	function testShouldAssociateProductIdWithIllustration()
	{
		return $this->markTestIncomplete();
	}
}