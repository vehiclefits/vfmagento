<?php
class Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_MMY_SimpleTest extends Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $this->csvData = 'sku, make, model, year
sku, honda, civic, 2000';
        
        $this->insertProduct( self::SKU );
    }
    
    function testSku()
    {
        $this->FitmentsImport($this->csvData);
        $fit = $this->getFitForSku( self::SKU );
        $this->assertEquals( 'honda', $fit->getLevel( 'make' )->getTitle() );
    }
    
    function testMake()
    {
        $this->FitmentsImport($this->csvData);
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda')), 'should import make' );
    }
    
    function testCountFitmentsIs1AfterSuccess()
    {
        $importer = $this->FitmentsImporterFromData($this->csvData);
        $importer->import();
        $this->assertEquals( 1, $importer->getCountFitments() );
    }
    
    function testAddedCountIs0IfFitAlreadyExists()
    {
        $importer = $this->FitmentsImporterFromData($this->csvData);
        $importer->import();
        
        $importer = $this->FitmentsImporterFromData($this->csvData);
        $importer->import();
        
        $this->assertEquals( 0, $importer->getCountFitments() );
    }
    
}