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
        $vehicle1 = $this->vehicleFinder()->findOneByLevels(array('make'=>'honda', 'model'=>'civic', 'year'=>2000));
        $vehicle2 = $this->vehicleFinder()->findOneByLevels(array('make'=>'honda', 'model'=>'civic', 'year'=>2001));

	$product->setCurrentlySelectedFit($vehicle2);
	$this->assertNull( $product->getPrice(), 'should not change price');

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

    function testChangesMinimalPrice()
    {
	$this->insertProduct('sku');

	$this->mappingsImport('sku, make, model, year, price
sku, honda, civic, 2000, 222.22');

	$product = $this->getProductForSku('sku');
	$product->setCurrentlySelectedFit($this->vehicleFinder()->findOneByLevels(array('make'=>'honda', 'model'=>'civic', 'year'=>2000)));
	$this->assertEquals( 222.22, $product->getMinimalPrice(), 'should change price based on selected vehicle');

    }

    function testChangesPrice2()
    {
	$this->insertProduct('sku');

	$this->mappingsImport('price,sku, make, model, year,
222.22,sku, honda, civic, 2000');

	$product = $this->getProductForSku('sku');
	$product->setCurrentlySelectedFit($this->vehicleFinder()->findOneByLevels(array('make'=>'honda', 'model'=>'civic', 'year'=>2000)));
	$this->assertEquals( 222.22, $product->getPrice(), 'should change price based on selected vehicle');

    }

    function testChangesFormattedPrice()
    {
	$this->insertProduct('sku');

	$this->mappingsImport('price,sku, make, model, year,
222.22,sku, honda, civic, 2000');

	$product = $this->getProductForSku('sku');
	$product->setCurrentlySelectedFit($this->vehicleFinder()->findOneByLevels(array('make'=>'honda', 'model'=>'civic', 'year'=>2000)));
	$this->assertEquals( 222.22, $product->getFormatedPrice(), 'should change "formatted price"');

    }
    
    function testGetsGlobalVehicle()
    {
        $this->insertProduct('sku');
        $vehicle = $this->createVehicle(array('make'=>'honda', 'model'=>'civic', 'year'=>2000));
	$this->mappingsImport('price,sku, make, model, year,
222.22,sku, honda, civic, 2000');

	$product = $this->getProductForSku('sku');
	$this->setRequestParams($vehicle->toValueArray());
        
        $this->assertNotEquals(null,$product->currentlySelectedFit());
	$this->assertEquals( 222.22, $product->getPrice(), 'should get price/fitment from global fitment"');
    }
}