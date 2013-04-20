<?php
class VF_Import_ProductFitments_CSV_ImportTests_YMM_SimpleTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
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
        $this->mappingsImport( $this->csvData );
        $fit = $this->getFitForSku( self::SKU );
        $this->assertEquals( 'honda', $fit->getLevel( 'make' )->getTitle() );
    }
    
    function testMake()
    {
        $this->mappingsImport( $this->csvData );
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda')), 'importer should be able to load makes (root levels) properly' );
    }
    
    function testCountMappingsIs1AfterSuccess()
    {
        $importer = $this->mappingsImporterFromData( $this->csvData );
        $importer->import();
        $this->assertEquals( 1, $importer->getCountMappings() );
    }    

//    function testSkippedCountIs1IfFitAlreadyExists()
//    {
//        $importer = new VF_Import_ProductFitments_CSV_Import_TestSubClass( $this->csvFile );
//        $importer->import();
        // execise ( again)
//        $importer = new VF_Import_ProductFitments_CSV_Import_TestSubClass( $this->csvFile );
//        $importer->import();
//        $this->assertEquals( 1, $importer->getCountSkippedMappings() );
//    }
    
}