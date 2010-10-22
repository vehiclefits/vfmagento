<?php
class Elite_Vafimporter_Model_VehiclesList_CSV_ImportTests_MMY_PerformanceTest extends Elite_Vafimporter_TestCase
{
    protected $csvData;

    function doSetUp()
    {
        $this->switchSchema('make,model,year');
        
        $this->csvData = $this->csvData();
    }
    
    function testPerformance()
    {
        // should import ~500 vehicles in <= 5 seconds
        $this->setMaxRunningTime(5);
        $importer = $this->vehiclesListImporter( $this->csvData );
        $importer->import();
    }
    
    function csvData()
    {
        return file_get_contents(dirname(__FILE__).'/PerformanceTest.csv');
    }

}
