<?php
class Elite_Vaftire_Model_Catalog_Product_ImportTests_LogTest extends Elite_Vaftire_Model_Catalog_Product_ImportTests_TestCase
{    
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $this->csvData = '"sku","section_width","aspect_ratio","diameter","tire_type"
"sku","205","55","16","2"';
        $this->csvFile = TEMP_PATH . '/product-tire-sizes.csv';
        file_put_contents( $this->csvFile, $this->csvData );
        
        $this->insertProduct('sku');
    }
    
    function testShouldLogAssignmentOfTireSizeToProduct()
    {
        $writer = new Zend_Log_Writer_Mock();
        $logger = new Zend_Log($writer);
        
        $importer = $this->importer( $this->csvFile );
        $importer->setLog($logger);
        $importer->import();
        
        $event = $writer->events[0];
        $this->assertEquals("Assigned tire size [205/55-16] to sku [sku]", $event['message'] );
    }
    
    function testShouldLogAssignmentOfVehicleToProduct()
    {
        
    }
}