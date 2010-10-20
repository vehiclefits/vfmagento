<?php
class Elite_Vafnote_Observer_Exporter_Mappings_CSVTest extends Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_TestCase
{    
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
        
        $this->csvData = 'sku, make, model, year, notes
sku, honda, civic, 2000, "code1,code2"';
        $this->csvFile = TESTFILES . '/mappings-single.csv';
        file_put_contents( $this->csvFile, $this->csvData );
        
        $this->insertProduct('sku');
    }
    
    /**
    
    *  Elite_Vafimporter_Model
    */
    function testNotes()
    {       
        $importer = new Elite_Vafimporter_Model_ProductFitments_CSV_Import_TestSubClass( $this->csvFile );
        $importer->import();
        
        $exporter = new Elite_Vafimporter_Model_ProductFitmentsExport_TestStub();
        $string = explode("\n",$exporter->export());
        $this->assertEquals( "sku,universal,make,model,year,notes", $string[0] );
        $this->assertEquals( "sku,0,honda,civic,2000,\"code1,code2\"", $string[1] );
    }
    
}

class Elite_Vafimporter_Model_ProductFitmentsExport_TestStub extends Elite_Vafimporter_Model_ProductFitments_CSV_Export
{
    protected function getProductTable()
    {
        return 'test_catalog_product_entity';
    }
}