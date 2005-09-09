<?php
class Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_MMY_InvalidFieldHeadersTest extends Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    /**
    * @expectedException Elite_Vafimporter_Model_VehiclesList_CSV_Exception_FieldHeaders
    */
    function testShouldThrowExceptionIfNoFieldHeaders()
    {
        $this->mappingsImport('');
    }
    
    /**
    * @expectedException Elite_Vafimporter_Model_VehiclesList_CSV_Exception_FieldHeaders
    */
    function testShouldThrowExceptionIfMakeMissing()
    {
        $this->mappingsImport('model,year');
    }
    
    /**
    * @expectedException Elite_Vafimporter_Model_VehiclesList_CSV_Exception_FieldHeaders
    */
    function testShouldThrowExceptionIfModelMissing()
    {
        $this->mappingsImport('make,year');
    }
    
    /**
    * @expectedException Elite_Vafimporter_Model_VehiclesList_CSV_Exception_FieldHeaders
    */
    function testShouldThrowExceptionIfYearMissing()
    {
        $this->mappingsImport('make,model');
    }
    
    /**
    * @expectedException Elite_Vafimporter_Model_VehiclesList_CSV_Exception_FieldHeaders
    */
    function testShouldThrowExceptionIfSkuMissing()
    {
        $this->mappingsImport('make,model,year');
    }
}