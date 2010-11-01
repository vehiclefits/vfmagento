<?php
class Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_MMY_PerformanceTest extends Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testPerformance()
    {
        return $this->markTestIncomplete();
        
        // should import 1,000 product applications in <= 7 seconds
        $this->setMaxRunningTime(5);
        $this->FitmentsImportFromFile($this->csvFile());
        
    }
    
    function csvFile()
    {
        return dirname(__FILE__).'/PerformanceTest.csv';
    }

}