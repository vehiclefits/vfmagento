<?php
class Elite_Vaf_Model_VehicleTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testSaveParenetheses()
    {
        $this->createMMY('FMC','HPSC-156 (PEAS)','1994');
        $this->assertTrue($this->vehicleExists(array('make'=>'FMC','model'=>'HPSC-156 (PEAS)', 'year'=>1994)), 'should be able to save vehicle with parentheses in its name');
    }
    
    function testSavePrefixingZero()
    {
        $this->createMMY('FHIL','039','1999');
        $this->assertTrue($this->vehicleExists(array('make'=>'FHIL','model'=>'039', 'year'=>1999)));
        $this->assertFalse($this->vehicleExists(array('make'=>'FHIL','model'=>'39', 'year'=>1999)));        
    }
        
    function testSavePrefixingZero2()
    {
        $this->createMMY('FHIL','039','1999');
        $this->createMMY('FHIL','039','1999');
        $this->createMMY('FHIL','39','1999');
        $this->assertTrue($this->vehicleExists(array('make'=>'FHIL','model'=>'039', 'year'=>1999)));
        $this->assertTrue($this->vehicleExists(array('make'=>'FHIL','model'=>'39', 'year'=>1999)));        
    }
        
    function testShouldTrimWhitespaces()
    {
        $this->createMMY('FHIL',' 039 ','1999');
        $this->assertTrue($this->vehicleExists(array('make'=>'FHIL','model'=>'039', 'year'=>1999)));
    }
}