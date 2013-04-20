<?php
class VF_Import_VehiclesList_CSV_ImportTests_MMY_InvalidFieldHeadersTest extends VF_Import_TestCase
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
        $this->importVehiclesList('');
    }
    
    /**
    * @expectedException VF_Import_VehiclesList_CSV_Exception_FieldHeaders
    */
    function testShouldThrowExceptionIfMakeMissing()
    {
        $this->importVehiclesList('model,year');
    }
    
    /**
    * @expectedException VF_Import_VehiclesList_CSV_Exception_FieldHeaders
    */
    function testShouldThrowExceptionIfModelMissing()
    {
        $this->importVehiclesList('make,year');
    }
    
    /**
    * @expectedException VF_Import_VehiclesList_CSV_Exception_FieldHeaders
    */
    function testShouldThrowExceptionIfYearMissing()
    {
        $this->importVehiclesList('make,model');
    }
}