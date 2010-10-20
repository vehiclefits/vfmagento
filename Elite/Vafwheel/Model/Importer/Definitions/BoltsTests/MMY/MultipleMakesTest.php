<?php
class Elite_Vafwheel_Model_Importer_Definitions_BoltsTests_MMY_MultipleVehiclesTest extends Elite_Vafwheel_Model_Importer_Definitions_BoltsTests_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testShouldImportHondaLugCount()
    {
        $this->importVehicleBolts(
            '"Make","Model","Year","Bolt Pattern"' . "\n" .
            'honda, civic, 2000, 4x114.3' . "\n" .
            'acura, integra, 2000, 5x117.3');
        $vehicle = $this->findVehicleByLevelsMMY( 'honda', 'civic', '2000' );
        $this->assertEquals( 4, $vehicle->boltPattern()->lug_count, 'should import lug count for honda' );
    }
    
    function testShouldImportHondaBoltDistance()
    {
        $this->importVehicleBolts(
            '"Make","Model","Year","Bolt Pattern"' . "\n" .
            'honda, civic, 2000, 4x114.3' . "\n" .
            'acura, integra, 2000, 5x117.3');
        $vehicle = $this->findVehicleByLevelsMMY( 'honda', 'civic', '2000' );
        $this->assertEquals( 114.3, $vehicle->boltPattern()->bolt_distance, 'should import bolt distance for honda' );
    }
    
    function testShouldImportAcuraLugCount()
    {
        $this->importVehicleBolts(
            '"Make","Model","Year","Bolt Pattern"' . "\n" .
            'honda, civic, 2000, 4x114.3' . "\n" .
            'acura, integra, 2000, 5x117.3');
        $vehicle = $this->findVehicleByLevelsMMY( 'acura', 'integra', '2000' );
        $this->assertEquals( 5, $vehicle->boltPattern()->lug_count, 'should import lug count for acura' );
    }
    
    function testShouldImportAcuraBoltDistance()
    {
        $this->importVehicleBolts(
            '"Make","Model","Year","Bolt Pattern"' . "\n" .
            'honda, civic, 2000, 4x114.3' . "\n" .
            'acura, integra, 2000, 5x117.3');
        $vehicle = $this->findVehicleByLevelsMMY( 'acura', 'integra', '2000' );
        $this->assertEquals( 117.3, $vehicle->boltPattern()->bolt_distance, 'should import bolt distance for acura' );
    }
}
