<?php
class Elite_Vaftire_Model_Importer_Definitions_TireSizeTests_MMY_YearRangeTest extends Elite_Vaftire_Model_Importer_Definitions_TireSizeTests_MMY_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testNoVehicle()
    {
        $this->importVehicleTireSizes(
            '"Make","Model","Year_Start","Year_End","Tire_Size"' . "\n" .
            ', , ,, ');
    }
    
    function testNoTireSize()
    {
        $this->importVehicleTireSizes(
            '"Make","Model","Year_Start","Year_End","Tire_Size"' . "\n" .
            'honda, civic, 2000, ');
        $vehicle = $this->findVehicleByLevelsMMY('honda','civic','2000');
        $tireSizes = $vehicle->tireSize();
        $this->assertEquals( 0, count($tireSizes), 'should import no tire size' );
    }
    
    function testShouldImportSingleYear()
    {
        $this->importVehicleTireSizes(
            '"Make","Model","Year_Start","Year_End","Tire_Size"' . "\n" .
            'honda, civic, 2000, 2000, 215/60-15');
        $vehicle = $this->findVehicleByLevelsMMY('honda','civic','2000');
        $tireSizes = $vehicle->tireSize();
        $this->assertEquals( 215, $tireSizes[0]->sectionWidth(), 'should import single year' );
    }
    
    function testShouldImportAdjacentYears()
    {
        $this->importVehicleTireSizes(
            '"Make","Model","Year_Start","Year_End","Tire_Size"' . "\n" .
            'honda, civic, 2000, 2001, 215/60-15');
        $vehicle = $this->findVehicleByLevelsMMY('honda','civic','2000');
        $tireSizes = $vehicle->tireSize();
        $this->assertEquals( 215, $tireSizes[0]->sectionWidth(), 'should import adjacent years' );
        
        $vehicle = $this->findVehicleByLevelsMMY('honda','civic','2001');
        $tireSizes = $vehicle->tireSize();
        $this->assertEquals( 215, $tireSizes[0]->sectionWidth(), 'should import adjacent years' );
    }
        
    function testShouldImportRangeOfYears()
    {
        $this->importVehicleTireSizes(
            '"Make","Model","Year_Start","Year_End","Tire_Size"' . "\n" .
            'honda, civic, 2000, 2002, 215/60-15');
        $vehicle = $this->findVehicleByLevelsMMY('honda','civic','2000');
        $tireSizes = $vehicle->tireSize();
        $this->assertEquals( 215, $tireSizes[0]->sectionWidth(), 'should import range of years' );
        
        $vehicle = $this->findVehicleByLevelsMMY('honda','civic','2001');
        $tireSizes = $vehicle->tireSize();
        $this->assertEquals( 215, $tireSizes[0]->sectionWidth(), 'should import range of years' );
                
        $vehicle = $this->findVehicleByLevelsMMY('honda','civic','2002');
        $tireSizes = $vehicle->tireSize();
        $this->assertEquals( 215, $tireSizes[0]->sectionWidth(), 'should import range of years' );
    }
    
}