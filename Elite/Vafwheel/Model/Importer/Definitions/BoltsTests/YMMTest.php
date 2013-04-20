<?php
class Elite_Vafwheel_Model_Importer_Definitions_BoltsTests_YMMTest extends Elite_Vafwheel_Model_Importer_Definitions_BoltsTests_TestCase
{
    protected $csvData;
    protected $csvFile;
    
    function doSetUp()
    {
        $this->switchSchema('year,make,model');
        
        $this->csvData = '"make","model","year_start","year_end","bolt pattern"
honda, civic, 2000, 2002, 1x114.3
acura, integra, 2000, 2003, 2x114.3';
        $this->csvFile = TESTFILES . '/bolt-definitions-range.csv';
        file_put_contents( $this->csvFile, $this->csvData );
        
        $importer = new Elite_Vafwheel_Model_Importer_Definitions_Bolts( $this->csvFile );
        $importer->import();
    }
    
    function testShouldImportLugCount()
    {
        $vehicle = $this->findVehicleByLevelsYMM( '2000', 'honda', 'civic' );
        $this->assertEquals( 1, $vehicle->boltPattern()->lug_count, 'should import lug count' );
    }

    function testShouldImportBoltDistance()
    {
        $vehicle = $this->findVehicleByLevelsYMM( '2000', 'honda', 'civic' );
        $this->assertEquals( 114.3, $vehicle->boltPattern()->bolt_distance, 'should import bolt distance' );
    }

}