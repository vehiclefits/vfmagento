<?php
class VF_Import_ProductFitments_CSV_ImportTests_MMTCTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema( 'make,model,chassis,trim' );
        $this->createImportFile();
    }
    
    function createImportFile()
    {
        $this->csvData = 'sku, make, model, trim, chassis
sku, honda, civic, the_trim, the_chassis';
        
        $this->insertProduct( self::SKU );
    }
    
    function testSku()
    {
        $importer = $this->mappingsImport( $this->csvData );
        $schema = new VF_Schema();
        $fit = $this->getFitForSku( self::SKU, $schema );
        $this->assertEquals( 'honda', $fit->getLevel( 'make' )->getTitle() );
    }
    
    function testMake()
    {
        return $this->markTestIncomplete();
//        $importer = new VF_Import_ProductFitments_CSV_Import_TestSubClass( $this->csvFile );
//        $importer->import();
//        $this->assertTrue( $this->entityTitleExists( 'make', 'honda' ), 'importer should be able to load makes (root levels) properly' );
    }
    
    function testSkippedProducts()
    {
        return $this->markTestIncomplete();
//        $data = 'sku, make, model, trim, chassis
//nonexistantsku, honda, civic, the_trim, the_chassis';
//        $file = TESTFILES . '/mappings-skipped.csv';
//        file_put_contents( $file, $data );
//        $importer = new VF_Import_ProductFitments_CSV_Import_TestSubClass( $file );
//        $importer->import();
//        $this->assertEquals( array( 'nonexistantsku' ), $importer->getSkippedSkus() );
    }
    
    function testErrorCountIs0AfterSuccess()
    {
        return $this->markTestIncomplete();
//        $importer = new VF_Import_ProductFitments_CSV_Import_TestSubClass( $this->csvFile );
//        $importer->import();
//        $this->assertEquals( array(), $importer->getErrors() );
    }
    
    function testSkippedCountIs0AfterSuccess()
    {
        return $this->markTestIncomplete();
//        $importer = new VF_Import_ProductFitments_CSV_Import_TestSubClass( $this->csvFile );
//        $importer->import();
//        $this->assertEquals( 0, $importer->getCountSkippedMappings() );
    }
    
    function testCountMappingsIs1AfterSuccess()
    {
        return $this->markTestIncomplete();
//        $importer = new VF_Import_ProductFitments_CSV_Import_TestSubClass( $this->csvFile );
//        $importer->import();
//        $this->assertEquals( 1, $importer->getCountMappings() );
    }
    
    function testSkippedCountIs1IfFitAlreadyExists()
    {
        return $this->markTestIncomplete();
//        $importer = new VF_Import_ProductFitments_CSV_Import_TestSubClass( $this->csvFile );
//        $importer->import();
        // execise ( again)
//        $importer = new VF_Import_ProductFitments_CSV_Import_TestSubClass( $this->csvFile );
//        $importer->import();
//        $this->assertEquals( 1, $importer->getCountSkippedMappings() );
    }
    
}