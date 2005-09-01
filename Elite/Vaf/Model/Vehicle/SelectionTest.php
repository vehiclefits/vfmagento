<?php
class Elite_Vaf_Model_Vehicle_SelectionTest extends Elite_Vaf_Helper_DataTestCase
{
    function testShouldNotContainVehicle()
    {
        $vehicle1 = $this->createVehicle(array('make'=>'Honda','model'=>'civic','year'=>2000));
        $vehicle2 = $this->createVehicle(array('make'=>'Honda','model'=>'civic','year'=>2001));

        $selection = new Elite_Vaf_Model_Vehicle_Selection($vehicle1);
        $this->assertFalse($selection->contains($vehicle2) );
    }

    function testShouldContainVehicle()
    {
        $vehicle = $this->createVehicle(array('make'=>'Honda','model'=>'civic','year'=>2000));
        $selection = new Elite_Vaf_Model_Vehicle_Selection($vehicle);
        $this->assertTrue($selection->contains($vehicle) );
    }


    function testShouldContainMultipleVehicles()
    {
        $vehicle1 = $this->createVehicle(array('make'=>'Honda','model'=>'civic','year'=>2000));
        $vehicle2 = $this->createVehicle(array('make'=>'Honda','model'=>'civic','year'=>2001));
        $selection = new Elite_Vaf_Model_Vehicle_Selection(array($vehicle1,$vehicle2));
        $this->assertTrue($selection->contains($vehicle1) );
        $this->assertTrue($selection->contains($vehicle2) );
    }

}