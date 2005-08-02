<?php
class Elite_VehiclesListImportTest extends Elite_Vafimporter_TestCase
{
    protected $csvData;

    function doSetUp()
    {
        ini_set('memory_limit','512M');
        $this->switchSchema('make,model,year');
    }
    
    protected function doTearDown()
    {
	ini_set('memory_limit','256M');
    }
    
    function testPerformance()
    {
        // should import ~500 vehicles in <= 5 seconds
        $this->setMaxRunningTime(5);
        $importer = $this->vehiclesListImporter( $this->csvData() );
        $importer->import();
    }
    
    function csvData()
    {
        return file_get_contents(dirname(__FILE__).'/VehiclesListImportTest.csv');
    }

}
