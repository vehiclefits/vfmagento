<?php
class Elite_Vafwheel_Model_Importer_Definitions_BoltsTests_MMY_YearRangeTest extends Elite_Vafwheel_Model_Importer_Definitions_BoltsTests_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testShouldImportLugCountForYear2000()
    {
        $this->importVehicleBolts(
            '"make","model","year_start","year_end","bolt pattern"' . "\n" .
            'honda, civic, 2000, 2001, 4x114.3' );
        $vehicle = $this->findVehicleByLevelsMMY( 'honda', 'civic', '2000' );
        $this->assertEquals( 4, $vehicle->boltPattern()->lug_count, 'should import lug count for year 2000' );
    }
    
    function testShouldImportBoltDistanceForYear2000()
    {
        $this->importVehicleBolts(
            '"make","model","year_start","year_end","bolt pattern"' . "\n" .
            'honda, civic, 2000, 2001, 4x114.3' );
        $vehicle = $this->findVehicleByLevelsMMY( 'honda', 'civic', '2000' );
        $this->assertEquals( 114.3, $vehicle->boltPattern()->bolt_distance, 'should import bolt distance for year 2000' );
    }
    
    function testShouldImportLugCountForYear2001()
    {
        $this->importVehicleBolts(
            '"make","model","year_start","year_end","bolt pattern"' . "\n" .
            'honda, civic, 2000, 2001, 4x114.3' );
        $vehicle = $this->findVehicleByLevelsMMY( 'honda', 'civic', '2001' );
        $this->assertEquals( 4, $vehicle->boltPattern()->lug_count, 'should import lug count for year 2001' );
    }
    
    function testShouldImportBoltDistanceForYear2001()
    {
        $this->importVehicleBolts(
            '"make","model","year_start","year_end","bolt pattern"' . "\n" .
            'honda, civic, 2000, 2001, 4x114.3' );
        $vehicle = $this->findVehicleByLevelsMMY( 'honda', 'civic', '2001' );
        $this->assertEquals( 114.3, $vehicle->boltPattern()->bolt_distance, 'should import bolt distance for year 2001' );
    }

}