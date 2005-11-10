<?php
class Elite_Vaf_Model_Level_FinderTests_ListInUsePerformanceTest extends Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('year,make,model,option,category,subcategory');
        #$this->mappingsImportFromFile(dirname(__FILE__).'/PerformanceTest.csv');
    }

    function testShouldNotIncludeOptionsNotInUse()
    {
        $this->insertProduct('sku1');
        $startTime = microtime();
        
        $make = new Elite_Vaf_Model_Level('year');
        $make->listInUse();
        
        $endTime = microtime();
        $this->assertTrue( $endTime - $startTime < .03, 'should take less than this much time to list stuff');
    }

}
