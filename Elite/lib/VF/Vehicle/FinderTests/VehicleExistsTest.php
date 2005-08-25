<?php
class VF_Vehicle_FinderTests_VehicleExistsTest extends Elite_Vaf_TestCase
{
    function testVehicleShouldExist()
    {
        $this->createMMY('Honda','Civic','2000');
        $this->assertTrue($this->vehicleFinder()->vehicleExists(array('make'=>'Honda', 'model'=>'Civic', 'year'=>'2000')), 'vehicle should exist');
    }
    
    function testVehicleShouldNotExist()
    {
        $this->assertFalse($this->vehicleFinder()->vehicleExists(array('make'=>'Honda', 'model'=>'Civic', 'year'=>'2000')), 'vehicle should not exist');
    }
}