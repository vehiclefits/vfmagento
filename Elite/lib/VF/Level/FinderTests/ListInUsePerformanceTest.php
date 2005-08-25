<?php
class VF_Level_FinderTests_ListInUsePerformanceTest extends Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('year,make,model');
        //$this->mappingsImportFromFile(dirname(__FILE__).'/product-fitments-import.csv');
    }

    function testShouldNotIncludeOptionsNotInUse()
    {
        return $this->markTestIncomplete();
        
        $this->insertProduct('sku1');
        $startTime = microtime();
        
        $year = new VF_Level('year');
        $year->listInUse();
        
        $endTime = microtime();
        echo $endTime-$startTime;
        
        //$this->assertTrue( $endTime - $startTime < .03, 'should take less than this much time to list stuff');
    }

}
