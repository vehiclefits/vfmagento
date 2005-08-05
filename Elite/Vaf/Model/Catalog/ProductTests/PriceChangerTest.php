<?php
class Elite_Vaf_Model_Catalog_ProductTests_PriceChangerTest extends Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_TestCase
{
    function testShouldNotChangePrice()
    {
	$this->insertProduct('sku');

	$this->mappingsImport('sku, make, model, year, price
sku, honda, civic, 2000, 222.22
sku, honda, civic, 2001');

	$product = $this->getProductForSku('sku');
	$product->setCurrentlySelectedFit($this->vehicleFinder()->findOneByLevels(array('make'=>'honda', 'model'=>'civic', 'year'=>2001)));
	$this->assertEquals( null, $product->getPrice(), 'should not change price');

    }

    function testShouldNotChangePrice_NoVehicle()
    {
	$this->insertProduct('sku');

	$this->mappingsImport('sku, make, model, year, price
sku, honda, civic, 2000, 222.22
sku, honda, civic, 2001');

	$product = $this->getProductForSku('sku');
	$this->assertEquals( null, $product->getPrice(), 'should not change price');

    }

    function testChangesPrice()
    {
	$this->insertProduct('sku');

	$this->mappingsImport('sku, make, model, year, price
sku, honda, civic, 2000, 222.22');

	$product = $this->getProductForSku('sku');
	$product->setCurrentlySelectedFit($this->vehicleFinder()->findOneByLevels(array('make'=>'honda', 'model'=>'civic', 'year'=>2000)));
	$this->assertEquals( 222.22, $product->getPrice(), 'should change price based on selected vehicle');

    }
}