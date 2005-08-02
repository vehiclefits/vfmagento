<?php
class Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_MMY_MemoryTest extends Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_TestCase
{
    protected $oldLimit;
    
    function doSetUp()
    {
        $this->switchSchema('model,year',true);
	$this->oldLimit = ini_get('memory_limit');
    }
    
    function testPerformance()
    {
	return $this->markTestIncomplete();
        ini_set('memory_limit','20M');
        $this->mappingsImportFromFile($this->csvFile());
    }

    function doTearDown()
    {
	ini_set('memory_limit',$this->oldLimit);
    }
    
    function csvFile()
    {
        return dirname(__FILE__).'/MemoryTest.csv';
    }

}