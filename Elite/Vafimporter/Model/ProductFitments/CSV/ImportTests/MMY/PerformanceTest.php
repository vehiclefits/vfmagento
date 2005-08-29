<?php
class Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_MMY_PerformanceTest extends Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testPerformance()
    {
        // should import 1,000 product applications in <= 10 seconds
        $this->setMaxRunningTime(10);
        $this->mappingsImportFromFile($this->csvFile());
        
    }
    
    function csvFile()
    {
        return dirname(__FILE__).'/PerformanceTest.csv';
    }

}