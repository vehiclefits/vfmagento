<?php
class Elite_Vafimporter_Model_VehiclesList_CSV_ImportTests_MMY_InvalidDelimiterTest extends Elite_Vafimporter_Model_VehiclesList_CSV_TestCase
{    
    protected $product_id;
    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');        
    }
    
    /**
    * @expectedException Exception
    */
    function testInvalidDelimiterCausesException()
    {
        $csvData = "make\tmodel\tyear
honda\tcivic\t2002";
        $csvFile = TESTFILES . '/definitions.csv';
        file_put_contents( $csvFile, $csvData );
        
        $importer = $this->vehiclesListImporter( $csvFile );
        $importer->import();
    }
 
}