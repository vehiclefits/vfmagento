<?php
class Elite_Vafdiagram_Model_ImporterTest extends Elite_Vafdiagram_Model_TestCase
{
	function doSetUp()
	{
		$this->switchSchema('make,model,year');
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
}