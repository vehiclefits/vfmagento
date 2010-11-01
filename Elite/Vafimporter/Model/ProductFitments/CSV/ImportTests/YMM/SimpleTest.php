<?php
class Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_YMM_SimpleTest extends Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema( 'year,make,model' );
        
        $this->csvData = 'sku, make, model, year
sku, honda, civic, 2000';
        
        $this->insertProduct( self::SKU );
    }

    function testSku()
    {
        $this->FitmentsImport( $this->csvData );
        $fit = $this->getFitForSku( self::SKU );
        $this->assertEquals( 'honda', $fit->getLevel( 'make' )->getTitle() );
    }
    
    function testMake()
    {
        $this->FitmentsImport( $this->csvData );
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda')), 'importer should be able to load makes (root levels) properly' );
    }
    
    function testCountFitmentsIs1AfterSuccess()
    {
        $importer = $this->FitmentsImporterFromData( $this->csvData );
        $importer->import();
        $this->assertEquals( 1, $importer->getCountFitments() );
    }    

//    function testSkippedCountIs1IfFitAlreadyExists()
//    {
//        $importer = new Elite_Vafimporter_Model_ProductFitments_CSV_Import_TestSubClass( $this->csvFile );
//        $importer->import();
        // execise ( again)
//        $importer = new Elite_Vafimporter_Model_ProductFitments_CSV_Import_TestSubClass( $this->csvFile );
//        $importer->import();
//        $this->assertEquals( 1, $importer->getCountSkippedFitments() );
//    }
    
}