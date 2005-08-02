<?php
class Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_MMY_UniversalTest extends Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $this->insertProduct( self::SKU );
    }
    
    function testMakesProductUniversal()
    {
        $this->mappingsImport('sku, make, model, year, universal
"sku","","","","1"');
        $this->assertTrue( $this->getProductForSku('sku')->isUniversal() );
    }
        
    
    function testMakesProductUniversal_YearRange()
    {
        $this->mappingsImport('sku, make, model, year_start, year_end, universal
"sku","","","","","1"');
        return $this->markTestIncomplete();
        //$this->assertTrue( $this->getProductForSku('sku')->isUniversal() );
    }
        
    function testDoesNotImportBlankDefinition()
    {
        $this->mappingsImport('sku, make, model, year, universal
"sku","","","","1"');
        
        $vehicleFinder = new Elite_Vaf_Model_Vehicle_Finder(new Elite_Vaf_Model_Schema());
        $vehicles = $vehicleFinder->findAll();
        $this->assertEquals( 0, count($vehicles));
    }
            
    function testDoesNotInsertNullVehicle()
    {
        $this->mappingsImport('sku, make, model, year, universal
"sku","","","","1"');
        
        $vehicleFinder = new Elite_Vaf_Model_Vehicle_Finder(new Elite_Vaf_Model_Schema());
        $count = $this->getReadAdapter()->query('select count(*) from elite_definition')->fetchColumn();
        $this->assertEquals( 0, $count);
    }
    
    function testShouldNotLogErrorsForUniversalRecord()
    {
        $importer = $this->mappingsImporterFromData('sku, make, model, year, universal
"sku","","","","1"');
        $importer->import();
        
        $writer = new Zend_Log_Writer_Mock();
        $logger = new Zend_Log($writer);
        $logger->addFilter(new Zend_Log_Filter_Priority(Zend_Log::NOTICE));
        $importer->setLog($logger);
        
        $importer->import();
        
        $this->assertEquals( 0, count($writer->events) );
    }
    
    function testShouldNotTallyInvalidVehicle()
    {
        $importer = $this->mappingsImporterFromData('sku, make, model, year, universal
"sku","","","","1"');
        $importer->import();

        $this->assertEquals( 0, $importer->invalidVehicleCount() );
    }
    
    function testShouldNotTallyInvalidVehicle_YearRange()
    {
        return $this->markTestIncomplete();
        $importer = $this->mappingsImporterFromData('sku, make, model, year_start, year_end, universal
"sku","","","","1"');
        $importer->import();

        $this->assertEquals( 0, $importer->invalidVehicleCount() );
    }
    
}
