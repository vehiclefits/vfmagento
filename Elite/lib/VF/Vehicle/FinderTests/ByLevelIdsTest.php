<?php

class VF_Vehicle_FinderTests_ByLevelIdsTest extends VF_Vehicle_FinderTests_TestCase
{

    function testShouldFindByAllLevels()
    {
	$vehicle = $this->createMMY('Honda', 'Civic', '2000');
	$vehicles = $this->getFinder()->findByLevelIds($vehicle->toValueArray());
	$this->assertEquals(1, count($vehicles), 'should find by levels');
    }

    function testShouldFindByMake()
    {
	$vehicle = $this->createMMY('Honda', 'Civic', '2000');
	$vehicles = $this->getFinder()->findByLevelIds(array('make' => $vehicle->getValue('make')));
	$this->assertEquals(1, count($vehicles), 'should find by make');
    }

    function testShouldFindByMakeAlternateParamaterStyle()
    {
	$vehicle = $this->createMMY('Honda', 'Civic', '2000');
	$vehicles = $this->getFinder()->findByLevelIds(array('make_id' => $vehicle->getValue('make')));
	$this->assertEquals(1, count($vehicles), 'should find by make w/ alternative paramater style (make_id)');
    }

    function testShouldFindOneByLevelIds()
    {
	$vehicle = $this->createMMY('Honda', 'Civic', '2000');

	$vehicle2 = $this->getFinder()->findOneByLevelIds(array('make_id' => $vehicle->getValue('make')));
	$this->assertEquals($vehicle->toValueArray(), $vehicle2->toValueArray(), 'should find one by level ids');
    }

    function testShouldFindOneByLevelIds_Partial()
    {
	$vehicle = $this->createMMY('Honda', 'Civic', '2000');

	$params = array('make' => $vehicle->getValue('make'));
	$vehicle2 = $this->getFinder()->findOneByLevelIds($params, VF_Vehicle_Finder::INCLUDE_PARTIALS);

	$params = array('make' => $vehicle->getValue('make'), 'model' => 0, 'year' => 0);
	$this->assertEquals($params, $vehicle2->toValueArray(), 'should find one by level ids (partial)');
    }

    function testShouldNotFindOneByLevelIds()
    {
	$vehicle2 = $this->getFinder()->findOneByLevelIds(array('make_id' => 1));
	$this->assertFalse($vehicle2, 'should not find one by level ids');
    }

    function testShouldFindPartialVehicleMake()
    {
	$make = new VF_Level('make');
	$make->setTitle('Honda');
	$make->save();

	$params = array('make' => $make->getId());
	$vehicles = $this->getFinder()->findByLevelIds($params, VF_Vehicle_Finder::INCLUDE_PARTIALS);
	$this->assertEquals(1, count($vehicles), 'should find partial vehicle by make');
    }

    function testShouldFindPartialVehicleMake2()
    {
	$vehicle = $this->createMMY('Honda', 'Civic', '2000');
	$make = $vehicle->getLevel('make');

	$params = array('make' => $make->getId());
	$vehicles = $this->getFinder()->findByLevelIds($params, VF_Vehicle_Finder::INCLUDE_PARTIALS);
	$this->assertEquals(3, count($vehicles), 'should find partial vehicle by make');
    }

    function testPartialVehicleShouldHaveMakeID()
    {
	$make = new VF_Level('make');
	$make->setTitle('Honda');
	$make->save();

	$params = array('make' => $make->getId());
	$vehicles = $this->getFinder()->findByLevelIds($params, VF_Vehicle_Finder::INCLUDE_PARTIALS);
	$this->assertEquals($make->getId(), $vehicles[0]->getValue('make'), 'partial vehicle should have make ID');
    }

    function testZeroShouldMatchPartialVehicle()
    {
	$make = new VF_Level('make');
	$make->setTitle('Honda');
	$make->save();

	$params = array('make' => $make->getId(), 'model' => 0, 'year' => 0);
	$vehicles = $this->getFinder()->findByLevelIds($params, VF_Vehicle_Finder::INCLUDE_PARTIALS);
	$this->assertEquals(1, count($vehicles), 'zero should match partial vehicle');
    }

    function testZeroShouldExcludeFullVehicle()
    {
	$vehicle = $this->createMMY('Honda', 'Civic', '2000');

	$params = array('make' => $vehicle->getValue('make'), 'model' => 0, 'year' => 0);
	$vehicles = $this->getFinder()->findByLevelIds($params);
	$this->assertEquals(1, count($vehicles), 'zero should exclude full vehicles');
    }

    function testShouldExcludeFullVehicle()
    {
	$vehicle = $this->createMMY('Honda', 'Civic', '2000');

	$params = array('make' => $vehicle->getValue('make'));
	$vehicles = $this->getFinder()->findByLevelIds($params, VF_Vehicle_Finder::EXACT_ONLY);
	$this->assertEquals(1, count($vehicles), 'zero should exclude full vehicles');
    }

    function testShouldFindPartial()
    {
	$vehicle = $this->createMMY('Honda', 'Civic', '2000');

	$params = array('make' => $vehicle->getValue('make'));
	$vehicle = $this->getFinder()->findOneByLevelIds($params, VF_Vehicle_Finder::EXACT_ONLY);
	$this->assertEquals(0, $vehicle->getValue('model'));
    }

}