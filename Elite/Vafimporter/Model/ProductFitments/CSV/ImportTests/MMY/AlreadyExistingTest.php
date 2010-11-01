<?php
class Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_MMY_AlreadyExistingTest extends Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $this->csvData = 'sku, make, model, year' . "\n" .
                         'sku, honda, civic, 2000';
        
        $this->insertProduct( self::SKU );
    }
    
    function testNonExistantSku_ShouldNotAffectSkippedCount()
    {
        $importer = $this->mappingsImporterFromData('sku, make, model, year' . "\n" .
                                                    'nonexist, honda, civic, 2000');
        $importer->import();
        $this->assertEquals( 0, $importer->getCountSkippedMappings(), 'non existant sku should NOT affect skipped count' );
    }
    
    function testSkippedCountIs0AfterSuccess()
    {
        $importer = $this->mappingsImporterFromData($this->csvData);
        $importer->import();
        $this->assertEquals( 0, $importer->getCountSkippedMappings() );
    }
    
    function testSkippedCountIs1IfFitAlreadyExists()
    {
        $importer = $this->mappingsImporterFromData($this->csvData);
        $importer->import();
        
        $importer = $this->mappingsImporterFromData($this->csvData);
        $importer->import();
        
        $this->assertEquals( 1, $importer->getCountSkippedMappings() );
    }
}