<?php
class Elite_Vafimporter_Model_VehiclesList_CSV_ImportTests_MMY_InvalidFieldHeadersTest extends Elite_Vafimporter_TestCase
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
        $this->importVehiclesList('');
    }
    
    /**
    * @expectedException Elite_Vafimporter_Model_VehiclesList_CSV_Exception_FieldHeaders
    */
    function testShouldThrowExceptionIfMakeMissing()
    {
        $this->importVehiclesList('model,year');
    }
    
    /**
    * @expectedException Elite_Vafimporter_Model_VehiclesList_CSV_Exception_FieldHeaders
    */
    function testShouldThrowExceptionIfModelMissing()
    {
        $this->importVehiclesList('make,year');
    }
    
    /**
    * @expectedException Elite_Vafimporter_Model_VehiclesList_CSV_Exception_FieldHeaders
    */
    function testShouldThrowExceptionIfYearMissing()
    {
        $this->importVehiclesList('make,model');
    }
}