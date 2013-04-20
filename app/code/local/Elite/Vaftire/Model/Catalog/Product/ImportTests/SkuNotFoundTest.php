<?php
class Elite_Vaftire_Model_Catalog_Product_ImportTests_SkuNotFoundTest extends Elite_Vaftire_Model_Catalog_Product_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testShouldSkipNotFoundSku()
    {
        $this->importVehicleTireSizes("make,model,year,tire_size\n".
                                      "honda,civic,2002,205/55-16");
        $this->import('"sku","section_width","aspect_ratio","diameter","tire_type"' . "\n" .
                      '"doesnt_exist","205","55","16","2"');
        
    }
    
    function importVehicleTireSizes($stringData)
    {
        $file = TESTFILES . '/vehicle-tire-sizes.csv';
        file_put_contents( $file, $stringData );
        $importer = new Elite_Vaftire_Model_Importer_Definitions_TireSize($file);
        $importer->import();
    }
    
    function import($stringData)
    {
        $stringData = '"sku","section_width","aspect_ratio","diameter","tire_type"
"sku9846546546465465","205","55","16","2"';
        $file = TESTFILES . '/product-tire-sizes.csv';
        file_put_contents( $file, $stringData );
        $importer = $this->importer( $file );
        $importer->import();
    }
   
}