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

}