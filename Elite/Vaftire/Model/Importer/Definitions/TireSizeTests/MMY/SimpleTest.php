<?php
class Elite_Vaftire_Model_Importer_Definitions_TireSizeTests_MMY_SimpleTest extends Elite_Vaftire_Model_Importer_Definitions_TireSizeTests_MMY_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testNoVehicle()
    {
        $this->importVehicleTireSizes(
            '"Make","Model","Year","Tire_Size"' . "\n" .
            ', , , ');
    }
    
    function testNoTireSize()
    {
        $this->importVehicleTireSizes(
            '"Make","Model","Year","Tire_Size"' . "\n" .
            'honda, civic, 2000, ');
        $vehicle = $this->findVehicleByLevelsMMY('honda','civic','2000');
        $tireSizes = $vehicle->tireSize();
        $this->assertEquals( 0, count($tireSizes), 'should import no tire size' );
    }
    
    function testShouldImportSectionWidth()
    {
        $this->importVehicleTireSizes(
            '"Make","Model","Year","Tire_Size"' . "\n" .
            'honda, civic, 2000, 215/60-15');
        $vehicle = $this->findVehicleByLevelsMMY('honda','civic','2000');
        $tireSizes = $vehicle->tireSize();
        $this->assertEquals( 215, $tireSizes[0]->sectionWidth(), 'should import section width' );
    }
    
    function testShouldImportAspectRatio()
    {
        $this->importVehicleTireSizes(
            '"Make","Model","Year","Tire_Size"' . "\n" .
            'honda, civic, 2000, 215/60-15');
        $vehicle = $this->findVehicleByLevelsMMY('honda','civic','2000');
        $tireSizes = $vehicle->tireSize();
        $this->assertEquals( 60, $tireSizes[0]->aspectRatio(), 'should import aspect ratio' );
    }
    
    function testShouldImportDiameter()
    {
        $this->importVehicleTireSizes(
            '"Make","Model","Year","Tire_Size"' . "\n" .
            'honda, civic, 2000, 215/60-15');
        $vehicle = $this->findVehicleByLevelsMMY('honda','civic','2000');
        $tireSizes = $vehicle->tireSize();
        $this->assertEquals( 15, $tireSizes[0]->diameter(), 'should import diameter' );
    }
    
}