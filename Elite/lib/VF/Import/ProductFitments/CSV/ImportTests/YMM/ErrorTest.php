<?php
class VF_Import_ProductFitments_CSV_ImportTests_YMM_ErrorTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema( 'year,make,model' );
        
        $this->csvData = 'sku, make, model, year
sku, honda, civic, 2000';
        
        $this->insertProduct( self::SKU );
    }
    
    function testNonExistantSku()
    {
        $data = 'sku, make, model, year
nonexistantsku, honda, civic, 2000';
        
        $importer = $this->mappingsImporterFromData($data);
        $importer->import();
        $this->assertEquals( array('nonexistantsku'), $importer->nonExistantSkus() );
    }
    
    function testRowsWithNonExistantSkus()
    {
        $data = 'sku, make, model, year
nonexistantsku, honda, civic, 2000';
        
        $importer = $this->mappingsImporterFromData($data);
        $importer->import();
        $this->assertEquals( 1, $importer->rowsWithNonExistantSkus(), 'should count the number of rows with non-existant SKUs' );
    }
    
    function testRowsWithNonExistantSkus_ShouldBe1OneWithYearRanges()
    {
        $data = 'sku, make, model, year_start,year_end
nonexistantsku, honda, civic, 2000,2001';
        
        $importer = $this->mappingsImporterFromData($data);
        $importer->import();
        $this->assertEquals( 1, $importer->rowsWithNonExistantSkus(), 'row count with invalid SKUs should be 1 even if multiple years' );
    }
    
    function testSkippedCountIs0AfterSuccess()
    {
        $importer = $this->mappingsImporterFromData( $this->csvData );
        $importer->import();
        $this->assertEquals( 0, $importer->getCountSkippedMappings() );
    }

}