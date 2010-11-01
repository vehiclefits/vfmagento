<?php
class Elite_Vafimporter_Model_ProductFitments_CSV_ExportTests_UniversalTest extends Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
        
        $this->csvData = 'sku, make, model, year, universal
sku123,  ,  ,  ,1';
        $this->csvFile = TESTFILES . '/Fitments-single.csv';
        file_put_contents( $this->csvFile, $this->csvData );
        
        
        $this->insertProduct( 'sku123' );
        $this->insertProduct( 'sku456' );
        
        $importer = new Elite_Vafimporter_Model_ProductFitments_CSV_Import_TestSubClass( $this->csvFile );
        $importer->import();
    }
    
    function testExportUniversal()
    {
        $exporter = new Elite_Vafimporter_Model_ProductFitments_CSV_ExportTests_TestSub();
        $output = explode( "\n", $exporter->export() );
        $this->assertEquals( 'sku,universal,make,model,year,notes', $output[0] );
        $this->assertEquals( 'sku123,1,,,,""', $output[1] );
    }
       
}
