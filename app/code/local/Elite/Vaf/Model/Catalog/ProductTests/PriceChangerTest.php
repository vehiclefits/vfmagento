<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Elite_Vaf_Model_Catalog_ProductTests_PriceChangerTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{
    function testShouldNotChangePrice()
    {
	$this->insertProduct('sku');

	$this->mappingsImport('sku, make, model, year, price
sku, honda, civic, 2000, 222.22
sku, honda, civic, 2001');
        
	$product = $this->getProductForSku('sku');
        $product->setPrice(1);
        $vehicle1 = $this->vehicleFinder()->findOneByLevels(array('make'=>'honda', 'model'=>'civic', 'year'=>2000));
        $vehicle2 = $this->vehicleFinder()->findOneByLevels(array('make'=>'honda', 'model'=>'civic', 'year'=>2001));

	$product->setCurrentlySelectedFit($vehicle2);
	$this->assertEquals( 1, $product->getPrice(), 'should not change price');

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

    function testDoesntChangeMinimalPrice()
    {
	$this->insertProduct('sku');

	$this->mappingsImport('sku, make, model, year, price
sku, honda, civic, 2000, 222.22');

	$product = $this->getProductForSku('sku');
	$this->assertNull( $product->getMinimalPrice(), 'should not change price when no vehicle');
    }

    function testChangesFinalPrice()
    {
	$this->insertProduct('sku');

	$this->mappingsImport('sku, make, model, year, price
sku, honda, civic, 2000, 222.22');

	$product = $this->getProductForSku('sku');
	$product->setCurrentlySelectedFit($this->vehicleFinder()->findOneByLevels(array('make'=>'honda', 'model'=>'civic', 'year'=>2000)));
	$this->assertEquals( 222.22, $product->getFinalPrice(), 'should change price based on selected vehicle');
    }

    function testWhenVehicleDoesntChangeFinalPrice()
    {
	$this->insertProduct('sku');

	$this->mappingsImport('sku, make, model, year, price
sku, honda, civic, 2000, 0');

	$product = $this->getProductForSku('sku');
        $product->setFinalPrice(1);
	$product->setCurrentlySelectedFit($this->vehicleFinder()->findOneByLevels(array('make'=>'honda', 'model'=>'civic', 'year'=>2000)));
	$this->assertEquals( 1, $product->getFinalPrice(), 'when vehicle is selected, should not change final price');
    }

    function testDoesntChangeFinalPrice()
    {
	$this->insertProduct('sku');

	$this->mappingsImport('sku, make, model, year, price
sku, honda, civic, 2000, 222.22');

	$product = $this->getProductForSku('sku');
	$this->assertNull( $product->getFinalPrice(), 'should not change price when no vehicle');
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

    function testShouldNotUsePrice0()
    {
        $this->insertProduct('sku');
        $vehicle = $this->createVehicle(array('make' => 'honda', 'model' => 'civic', 'year' => 2000));
        $this->mappingsImport(
            'price,sku, make, model, year,
            0,sku, honda, civic, 2000'
        );

        $product = $this->getProductForSku('sku');
        $product->setPrice(5);
        $product->setMinimalPrice(5);
        $product->setFinalPrice(5);
        //$product->setFormattedPrice(5);
        $this->setRequestParams($vehicle->toValueArray());

        $this->assertEquals(5, $product->getPrice(), 'should never show $0 as price"');
        $this->assertEquals(5, $product->getMinimalPrice(), 'should never show $0 as price"');
        $this->assertEquals(5, $product->getFinalPrice(), 'should never show $0 as price"');
        $this->assertEquals(5, $product->getFormatedPrice(), 'should never show $0 as price"');
    }
}