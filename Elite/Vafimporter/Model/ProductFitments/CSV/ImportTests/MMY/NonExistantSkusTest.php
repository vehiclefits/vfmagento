<?php
class Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_MMY_NonExistantSkusTest extends Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
        
        $this->csvData = 'sku, make, model, year' . "\n" .
                         'sku, honda, civic, 2000';
        
        $this->insertProduct( self::SKU );
    }
    
    function testWhenOneRow_ShouldReportSingleMissingSKU()
    {
        $importer = $this->mappingsImporterFromData(
            'sku, make, model, year' . "\n" .
            'nonexistantsku, honda, civic, 2000');
        $importer->import();
        $this->assertEquals( array( 'nonexistantsku' ), $importer->nonExistantSkus(), 'should report a single missing SKU' );
    }
    
    function testWhenUsingYearRanges_ShouldReportSingleMissingSKU()
    {
        return $this->markTestIncomplete();
    }
    
    function testWhenMultipleRowsSameSku_ShouldReportSingleSKU()
    {
        $importer = $this->mappingsImporterFromData(
            'sku, make, model, year' . "\n" .
            'nonexistantsku, honda, civic, 2000' . "\n" .
            'nonexistantsku, honda, civic, 2001');
        $importer->import();
        $this->assertEquals( array( 'nonexistantsku' ), $importer->nonExistantSkus(), 'when multiple rows with the same SKU, should report one missing SKU' );
    }

    function testShouldCountErrorsNotSKUs()
    {
        $importer = $this->mappingsImporterFromData(
            'sku, make, model, year' . "\n" .
            'nonexistantsku, honda, civic, 2000' . "\n" .
            'nonexistantsku, honda, civic, 2001');
        $importer->import();
        $this->assertEquals( 2, $importer->nonExistantSkusCount(), 'should count the errors not the SKUs' );
    }
    
    function testShouldLogMissingSku()
    {
        $importer = $this->mappingsImporterFromData(
            'sku,make,model,year' . "\n" . 
            'sku1,honda,civic,2000');
        
        $writer = new Zend_Log_Writer_Mock();
        $logger = new Zend_Log($writer);
        $logger->addFilter(new Zend_Log_Filter_Priority(Zend_Log::NOTICE));
        $importer->setLog($logger);
        
        $importer->import();
        
        $event = $writer->events[0];
        $this->assertEquals( 'Line(1) Non Existant SKU \'sku1\'', $event['message'] );
    }

    function testShouldLogMissingSku_CorrectLineNumber()
    {
        $importer = $this->mappingsImporterFromData(
            'sku,make,model,year' . "\n" . 
            'sku1,honda,civic,2000' . "\n" .
            'sku2,honda,civic,2000');
        
        $writer = new Zend_Log_Writer_Mock();
        $logger = new Zend_Log($writer);
        $logger->addFilter(new Zend_Log_Filter_Priority(Zend_Log::NOTICE));
        $importer->setLog($logger);
        
        $importer->import();
        
        $event = $writer->events[1];
        $this->assertEquals( 'Line(2) Non Existant SKU \'sku2\'', $event['message'] );
    }

}