<?php
class Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_MMY_CharacterSetTest extends Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_TestCase
{
    protected function doSetUp()
    {
        $this->getReadAdapter()->query('SET GLOBAL character_set_server=UTF8;');
        $this->getReadAdapter()->query('SET character_set_database=utf8;');
	 
	$this->switchSchema('make,model,year',true);
	
        $this->csvData = 'sku, make, model, year
sku, honda, civic, 2000';

        $this->insertProduct( self::SKU );
    }

    function testSku()
    {
        $this->mappingsImport($this->csvData);
        $fit = $this->getFitForSku( self::SKU );
        $this->assertEquals( 'honda', $fit->getLevel( 'make' )->getTitle() );
    }
    
    function testMake()
    {
        $this->mappingsImport($this->csvData);
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda')), 'should import make' );
    }

    function testCountMappingsIs1AfterSuccess()
    {
        $importer = $this->mappingsImporterFromData($this->csvData);
        $importer->import();
        $this->assertEquals( 1, $importer->getCountMappings() );
    }

    function testAddedCountIs0IfFitAlreadyExists()
    {
        $importer = $this->mappingsImporterFromData($this->csvData);
        $importer->import();

        $importer = $this->mappingsImporterFromData($this->csvData);
        $importer->import();

        $this->assertEquals( 0, $importer->getCountMappings() );
    }

}