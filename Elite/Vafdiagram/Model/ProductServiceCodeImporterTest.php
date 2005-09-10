<?php

class Elite_Vafdiagram_Model_ProductServiceCodeImporterTest extends Elite_Vafdiagram_Model_TestCase
{

    function doSetUp()
    {
	$this->switchSchema('make,model,year');
    }

    function testShouldIgnoreUnknownSKUs()
    {
	$this->importProductServiceCodes('sku,service_code' . "\n" .
		'sku2,123' . "\n" .
		'sku1,456' . "\n" .
		'sku1,456');
    }

    function testShouldImportServiceCodes()
    {
	$productId = $this->insertProduct('sku1');

	$this->importProductServiceCodes('sku,service_code' . "\n" .
		'sku1,123' . "\n" .
		'sku1,456');
	$product = $this->product($productId);
	$this->assertEquals(array(123, 456), $product->serviceCodes(), 'should import multiple service codes for product');
    }

    function testShouldSkipDuplicates()
    {
	$productId = $this->insertProduct('sku1');

	$this->importProductServiceCodes('sku,service_code' . "\n" .
		'sku1,123' . "\n" .
		'sku1,123');
	$product = $this->product($productId);
	$this->assertEquals(array(123), $product->serviceCodes(), 'should skip duplicates');
    }

    function testShouldImportCallout()
    {
	$productId = $this->insertProduct('sku1');

	$this->importProductServiceCodes('sku,category1,service_code,callout' . "\n" .
		'sku1,1,123,1' . "\n" .
		'sku1,2,456,2');
	$product = $this->product($productId);
	$this->assertEquals(1, $product->callout(array('category1' => 1)), 'should import callout');
	$this->assertEquals(2, $product->callout(array('category1' => 2)), 'should import callout');
    }

    function testShouldAssociateCategory1WithServiceCode()
    {
	$productId = $this->insertProduct('sku1');

	$this->importProductServiceCodes('sku,category1,service_code' . "\n" .
		'sku1,1,123' . "\n" .
		'sku1,2,456');
	$product = $this->product($productId);
	$this->assertEquals(array(123), $product->serviceCodes(array('category1' => 1)), 'should assocaite category 1 with product service codes');
	$this->assertEquals(array(456), $product->serviceCodes(array('category1' => 2)), 'should assocaite category 1 with product service codes');
    }

    function testShouldAssociateCategory2WithServiceCode()
    {
	$productId = $this->insertProduct('sku1');

	$this->importProductServiceCodes('sku,category1,category2,service_code' . "\n" .
		'sku1,1,1,123' . "\n" .
		'sku1,1,2,456');
	$product = $this->product($productId);
	$this->assertEquals(array(123), $product->serviceCodes(array('category1' => 1, 'category2' => 1)), 'should assocaite category 2 with product service codes');
	$this->assertEquals(array(456), $product->serviceCodes(array('category1' => 1, 'category2' => 2)), 'should assocaite category 2 with product service codes');
    }

    function testShouldAssociateCategory3WithServiceCode()
    {
	$productId = $this->insertProduct('sku1');

	$this->importProductServiceCodes('sku,category1,category2,category3,service_code' . "\n" .
		'sku1,1,1,1,123' . "\n" .
		'sku1,1,1,2,456');
	$product = $this->product($productId);
	$this->assertEquals(array(123), $product->serviceCodes(array('category1' => 1, 'category2' => 1, 'category3' => 1)), 'should assocaite category 3 with product service codes');
	$this->assertEquals(array(456), $product->serviceCodes(array('category1' => 1, 'category2' => 1, 'category3' => 2)), 'should assocaite category 3 with product service codes');
    }

    function testShouldAssociateCategory4WithServiceCode()
    {
	$productId = $this->insertProduct('sku1');

	$this->importProductServiceCodes('sku,category1,category2,category3,category4,service_code' . "\n" .
		'sku1,1,1,1,1,123' . "\n" .
		'sku1,1,1,1,2,456');
	$product = $this->product($productId);
	$this->assertEquals(array(123), $product->serviceCodes(array('category1' => 1, 'category2' => 1, 'category3' => 1, 'category4' => 1)), 'should assocaite category 4 with product service codes');
	$this->assertEquals(array(456), $product->serviceCodes(array('category1' => 1, 'category2' => 1, 'category3' => 1, 'category4' => 2)), 'should assocaite category 4 with product service codes');
    }

    function testShouldAssociateCategory1WithIllustration()
    {
	$productId = $this->insertProduct('sku1');

	$this->importProductServiceCodes('sku,category1,illustration_id,service_code' . "\n" .
		'sku1,1,1234,123' . "\n" .
		'sku1,2,4567,456');
	$product = $this->product($productId);

	$actual = $product->illustrationId(array(
		    'category1' => 1,
		    'service_code' => 123
		));
	$this->assertEquals(1234, $actual, 'should lookup have correct illustration ID for category & service code combination');
    }

    function testShouldAssociateProductIdWithIllustration()
    {
	return $this->markTestIncomplete();
    }

}