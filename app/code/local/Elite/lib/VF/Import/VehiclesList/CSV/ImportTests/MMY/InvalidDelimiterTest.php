<?php
class VF_Import_VehiclesList_CSV_ImportTests_MMY_InvalidDelimiterTest extends VF_Import_TestCase
{    
    protected $product_id;
    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');        
    }
    
    /**
    * @expectedException VF_Import_VehiclesList_CSV_Exception_FieldHeaders
    */
    function testInvalidDelimiterCausesException()
    {
        $csvData = "make\tmodel\tyear
honda\tcivic\t2002";
  
        
        $importer = $this->vehiclesListImporter( $csvData );
        $importer->import();
    }
 
}