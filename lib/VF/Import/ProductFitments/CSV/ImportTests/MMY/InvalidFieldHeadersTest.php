<?php
class VF_Import_ProductFitments_CSV_ImportTests_MMY_InvalidFieldHeadersTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    /**
    * @expectedException VF_Import_VehiclesList_CSV_Exception_FieldHeaders
    */
    function testShouldThrowExceptionIfNoFieldHeaders()
    {
        $this->mappingsImport('');
    }
    
    /**
    * @expectedException VF_Import_VehiclesList_CSV_Exception_FieldHeaders
    */
    function testShouldThrowExceptionIfMakeMissing()
    {
        $this->mappingsImport('model,year');
    }
    
    /**
    * @expectedException VF_Import_VehiclesList_CSV_Exception_FieldHeaders
    */
    function testShouldThrowExceptionIfModelMissing()
    {
        $this->mappingsImport('make,year');
    }
    
    /**
    * @expectedException VF_Import_VehiclesList_CSV_Exception_FieldHeaders
    */
    function testShouldThrowExceptionIfYearMissing()
    {
        $this->mappingsImport('make,model');
    }
    
    /**
    * @expectedException VF_Import_VehiclesList_CSV_Exception_FieldHeaders
    */
    function testShouldThrowExceptionIfSkuMissing()
    {
        $this->mappingsImport('make,model,year');
    }
}