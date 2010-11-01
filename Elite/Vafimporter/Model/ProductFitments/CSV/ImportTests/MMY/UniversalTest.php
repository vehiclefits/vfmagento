<?php
class Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_MMY_UniversalTest extends Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
        
        $this->csvData = 'sku, make, model, year, universal
sku,,,,1';
        
        $this->insertProduct( self::SKU );
    }
    
    function testMakesProductUniversal()
    {
        $this->FitmentsImport($this->csvData);
        $this->assertTrue( $this->getProductForSku('sku')->isUniversal() );
    }
        
    function testDoesNotImportBlankDefinition()
    {
        $this->FitmentsImport($this->csvData);
        
        $vehicleFinder = new Elite_Vaf_Model_Vehicle_Finder(new Elite_Vaf_Model_Schema());
        $vehicles = $vehicleFinder->findAll();
        
        $this->assertEquals( 0, count($vehicles));
    }
    
}
