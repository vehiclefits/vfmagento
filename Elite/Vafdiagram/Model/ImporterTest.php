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
	
	function testShouldImportProductServiceCodes()
	{
		$productId = $this->insertProduct('sku1');
		
		$this->importProductServiceCodes('sku,service_code' . "\n" .
										 'sku1,123' . "\n" . 
										 'sku1,456');
		$product = $this->product($productId);		
		$this->assertEquals( array(123,456), $product->serviceCodes(), 'should import multiple service codes for product');
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
	
	function testShouldAssociateServiceCodeToVehicle()
	{
		$product = $this->newProduct(1);
		$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
		$product->addServiceCode(123);
		
		$this->import('sku,make,model,year,service_code' . "\n" . 
					  ',Honda,Civic,2000,123');
		
		$vehicle = $this->vehicleFinder()->findOneByLevels(array('make'=>'Honda', 'model'=>'Civic', 'year'=>'2000'));
		$vehicle = new Elite_Vafdiagram_Model_Vehicle($vehicle);
		$this->assertEquals('123', $vehicle->serviceCode(), 'should associate service code to vehicle');
	}
	
	function import($data)
    {
    	$file = TESTFILES . '/mappings.csv';
        file_put_contents( $file, $data );
        $import = new Elite_Vafdiagram_Model_ProductFitments_CSV_Import_TestSubClass($file);
        $import->import();
    }
    
    function importProductServiceCodes($data)
    {
    	$file = TESTFILES . '/servicecodes.csv';
    	file_put_contents( $file, $data );
        $importer = new Elite_Vafdiagram_Model_ProductServiceCodeImporter_TestSubClass($file);
        $importer->import();
    }
    
	function product($id)
	{
		$product = new Elite_Vaf_Model_Catalog_Product;
		$product->setId($id);
		$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
		return $product;
	}
     
}

class Elite_Vafdiagram_Model_ProductServiceCodeImporter_TestSubClass extends Elite_Vafdiagram_Model_ProductServiceCodeImporter
{
	function getProductTable()
    {
        return 'test_catalog_product_entity';
    }
}

class Elite_Vafdiagram_Model_ProductFitments_CSV_Import_TestSubClass extends Elite_Vafdiagram_Model_ProductFitments_CSV_Import
{
	function getProductTable()
    {
        return 'test_catalog_product_entity';
    }
}