<?php
class Elite_Vafdiagram_Model_ImporterTest extends Elite_Vaf_TestCase
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
	
	function testShouldPersistServiceCodes()
	{
		$product = $this->newProduct(1);
		$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
		$product->addServiceCode(123);
		
		$product = $this->newProduct(1);
		$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
		$this->assertEquals( array(123), $product->serviceCodes(), 'should persist service codes');
	}
	
	function testShouldImportFitmentsWithServiceCodeInsteadOfSku()
	{
		$product = $this->newProduct(1);
		$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
		$product->addServiceCode(123);
		
		$this->import('sku,make,model,year,service_code' . "\n" . 
					  ',Honda,Civic,2000,123');
		
		$this->assertEquals(1, count($product->getFits()), 'should import fitments from service code');
	}
	
	function testShouldNotImportWrongFitmentsWhenServiceCodeDiffers()
	{
		$product = $this->newProduct(1);
		$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
		$product->addServiceCode(123);
		
		$this->import('sku,make,model,year,service_code' . "\n" . 
					  ',Honda,Civic,2000,456');
		
		$this->assertEquals(0, count($product->getFits()), 'should not import wrong fitments when service code differs');
	}
	
	function import($data)
    {
    	$file = TESTFILES . '/mappings.csv';
        file_put_contents( $file, $data );
        $import = new Elite_Vafdiagram_Model_ProductFitments_CSV_Import_TestSubClass($file);
        $import->import();
    }
     
}

class Elite_Vafdiagram_Model_ProductFitments_CSV_Import_TestSubClass extends Elite_Vafdiagram_Model_ProductFitments_CSV_Import
{
	function getProductTable()
    {
        return 'test_catalog_product_entity';
    }
}