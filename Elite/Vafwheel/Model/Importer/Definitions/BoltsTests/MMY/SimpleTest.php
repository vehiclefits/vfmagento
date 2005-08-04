<?php
class Elite_Vafwheel_Model_Importer_Definitions_BoltsTests_MMY_SimpleTest extends Elite_Vafwheel_Model_Importer_Definitions_BoltsTests_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testShouldImportLugCount()
    {
        $this->importVehicleBolts(
           '"make","model","year","bolt pattern"' . "\n" .
            'honda, civic, 2000, 4x114.3');
        $vehicle = $this->findVehicleByLevelsMMY( 'honda', 'civic', '2000' );
        $this->assertEquals( 4, $vehicle->boltPattern()->lug_count, 'should import lug count' );
    }
    
    function testShouldImportBoltDistance()
    {
        $this->importVehicleBolts(
            '"make","model","year","bolt pattern"' . "\n" .
            'honda, civic, 2000, 4x114.3');
        $vehicle = $this->findVehicleByLevelsMMY( 'honda', 'civic', '2000' );
        $this->assertEquals( 114.3, $vehicle->boltPattern()->bolt_distance, 'should import bolt distance' );
    }

}