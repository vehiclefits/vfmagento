<?php
class Elite_FitmentsImportTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{
    function doSetUp()
    {
        
    }
    
    protected function doTearDown()
    {
	ini_set('memory_limit','256M');
    }
    
    function testShouldImport1kProductsInTenSeconds()
    {
        ini_set('memory_limit','512M');
        $this->switchSchema('make,model,year');
        $this->setMaxRunningTime(10);
        $this->mappingsImportFromFile($this->csvFile());
    }
    
    function testMemory()
    {
        ini_set('memory_limit','12M');
        $this->switchSchema('model,year',true);
        $this->mappingsImportFromFile($this->csvFile());
    }
    
    function csvFile()
    {
        return dirname(__FILE__).'/FitmentsImportTest.csv';
    }

}