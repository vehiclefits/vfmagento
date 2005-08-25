<?php

class Elite_Vafwheel_Model_FlexibleSearchTests_VehicleSearchTest extends Elite_Vaf_TestCase
{

    /** @var VF_Vehicle */
    protected $vehicle;

    function doSetUp()
    {
	$this->switchSchema('make,model,year');
	$this->vehicle = $this->createMMY();
	$this->vehicle->save();
    }

    function testShouldBeAbleToSearchByVehicle()
    {
	$product = $this->newWheelProduct(1);
	$product->addVafFit($this->vehicle->toValueArray());
	$_SESSION = $this->vehicle->toValueArray();
	$this->assertEquals(array(1), $this->flexibleWheelSearch()->doGetProductIds(), 'should be able to search by vehicle');
    }

    function testWheelSizeShouldPrecedeVehicleForWheelProducts()
    {
	$product = $this->newWheelProduct(1);
	$product->addBoltPattern($this->boltPattern('5x114.3'));
	$product->addVafFit($this->vehicle->toValueArray());

	$this->setRequestParams(array('lug_count' => '4', 'stud_spread' => '114.3'));
	$_SESSION = $this->vehicle->toValueArray();
	$this->assertEquals(array(0), $this->flexibleWheelSearch()->doGetProductIds(), 'wheel size should precede vehicle for wheel products');
    }

    function testWheelSizeShouldNotPrecedeVehicleForNonWheelProducts()
    {
	$product = $this->newWheelProduct(1);
	$product->addVafFit($this->vehicle->toValueArray());

	$this->setRequestParams(array('lug_count' => '4', 'stud_spread' => '114.3'));
	$_SESSION = $this->vehicle->toValueArray();
	return $this->markTestIncomplete();
	//$this->assertEquals( array(1), $this->flexibleWheelSearch()->doGetProductIds(), 'wheel size should not precede vehicle for non wheel products' );
    }

}
