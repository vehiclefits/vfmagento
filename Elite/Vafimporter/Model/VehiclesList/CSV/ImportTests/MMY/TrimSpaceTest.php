<?php
class Elite_Vafimporter_Model_VehiclesList_CSV_ImportTests_MMY_TrimSpaceTest extends Elite_Vafimporter_Model_VehiclesList_CSV_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testShouldTrimSpace()
    {
        $this->importVehiclesList('make, model, year' . "\n" .
                                  'honda, civic," 2000"');
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'civic', 'year'=>'2000')), 'importer should trim space' );
    }
}