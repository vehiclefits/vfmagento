<?php
class Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_MMY_SkuDoesntExistTest extends Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
        
        $this->csvData = 'sku, make, model, year' . "\n" .
                         'sku, honda, civic, 2000';
        
        $this->insertProduct( self::SKU );
    }

    function testWhenUsingYearRanges_ShouldReportSingleRowWithMissingSKU()
    {
        $data = 'sku, make, model, year_start,year_end
nonexistantsku, honda, civic, 2000,2001';
        
        $importer = $this->mappingsImporterFromData($data);
        $importer->import();
        $this->assertEquals( 1, $importer->rowsWithNonExistantSkus(), 'row count with invalid SKUs should be 1 even if multiple years' );
    }

}