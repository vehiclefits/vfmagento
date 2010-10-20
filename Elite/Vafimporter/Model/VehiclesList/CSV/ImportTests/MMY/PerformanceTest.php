<?php
class Elite_Vafimporter_Model_VehiclesList_CSV_ImportTests_MMY_PerformanceTest extends Elite_Vafimporter_Model_VehiclesList_CSV_TestCase
{
    protected $csvData;
    protected $csvFile;

    function doSetUp()
    {
        $this->switchSchema('make,model,year');
        
        $this->csvData = $this->csvData();
        $this->csvFile = TESTFILES . '/vehicles.csv';
        file_put_contents( $this->csvFile, $this->csvData );
    }
    
    function testPerformance()
    {
        // should import ~500 vehicles in <= 5 seconds
        $this->setMaxRunningTime(5);
        $importer = $this->getDefinitions( $this->csvFile );
        $importer->import();
    }
    
    function csvData()
    {
        return file_get_contents(dirname(__FILE__).'/PerformanceTest.csv');
    }

}