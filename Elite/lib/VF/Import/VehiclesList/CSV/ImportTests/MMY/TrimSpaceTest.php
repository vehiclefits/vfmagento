<?php
class VF_Import_VehiclesList_CSV_ImportTests_MMY_TrimSpaceTest extends VF_Import_TestCase
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