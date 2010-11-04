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
        $this->mappingsImport($this->csvData);
        $this->assertTrue( $this->getProductForSku('sku')->isUniversal() );
    }
        
    function testDoesNotImportBlankDefinition()
    {
        $this->mappingsImport($this->csvData);
        
        $vehicleFinder = new Elite_Vaf_Model_Vehicle_Finder(new Elite_Vaf_Model_Schema());
        $vehicles = $vehicleFinder->findAll();
        $this->assertEquals( 0, count($vehicles));
    }
            
    function testDoesNotInsertNullVehicle()
    {
        $this->mappingsImport($this->csvData);
        
        $vehicleFinder = new Elite_Vaf_Model_Vehicle_Finder(new Elite_Vaf_Model_Schema());
        $count = $this->getReadAdapter()->query('select count(*) from elite_definition')->fetchColumn();
        $this->assertEquals( 0, $count);
    }
    
    function testShouldNotLogErrorsForUniversalRecord()
    {
        $importer = $this->mappingsImporterFromData($this->csvData);
        $importer->import();
        
        $writer = new Zend_Log_Writer_Mock();
        $logger = new Zend_Log($writer);
        $logger->addFilter(new Zend_Log_Filter_Priority(Zend_Log::NOTICE));
        $importer->setLog($logger);
        
        $importer->import();
        
        $this->assertEquals( 0, count($writer->events) );
    }
    
}
