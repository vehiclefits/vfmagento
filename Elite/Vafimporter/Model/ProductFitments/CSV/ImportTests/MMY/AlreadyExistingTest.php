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
        $importer = $this->FitmentsImporterFromData('sku, make, model, year' . "\n" .
                                                    'nonexist, honda, civic, 2000');
        $importer->import();
        $this->assertEquals( 0, $importer->getCountSkippedFitments(), 'non existant sku should NOT affect skipped count' );
    }
    
    function testSkippedCountIs0AfterSuccess()
    {
        $importer = $this->FitmentsImporterFromData($this->csvData);
        $importer->import();
        $this->assertEquals( 0, $importer->getCountSkippedFitments() );
    }
    
    function testSkippedCountIs1IfFitAlreadyExists()
    {
        $importer = $this->FitmentsImporterFromData($this->csvData);
        $importer->import();
        
        $importer = $this->FitmentsImporterFromData($this->csvData);
        $importer->import();
        
        $this->assertEquals( 1, $importer->getCountSkippedFitments() );
    }
}