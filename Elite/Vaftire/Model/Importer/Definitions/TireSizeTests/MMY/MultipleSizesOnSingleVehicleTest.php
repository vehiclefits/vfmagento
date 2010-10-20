<?php
class Elite_Vaftire_Model_Importer_Definitions_TireSizeTests_MMY_MultipleSizesOnSingleVehicleTest extends Elite_Vaftire_Model_Importer_Definitions_TireSizeTests_MMY_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testShouldImportMultipleSizesOnSingleVehicle()
    {
        $this->importVehicleTireSizes(
            '"Make","Model","Year","Tire_Size"' . "\n" .
            'honda, civic, 2000, 215/60-15' . "\n" . 
            'honda, civic, 2000, 215/60-16');
        $vehicle = $this->findVehicleByLevelsMMY('honda','civic','2000');
        $this->assertEquals( 2, count($vehicle->tireSize()), 'should import multiple tire sizes' );
    }
    
    function testShouldSkipDuplicates()
    {
        $this->importVehicleTireSizes(
            '"Make","Model","Year","Tire_Size"' . "\n" .
            'honda, civic, 2000, 215/60-15' . "\n" . 
            'honda, civic, 2000, 215/60-15');
        $vehicle = $this->findVehicleByLevelsMMY('honda','civic','2000');
        $this->assertEquals( 1, count($vehicle->tireSize()), 'should skip duplicate sizes for the same vehicle' );
    }
}