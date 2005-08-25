<?php
class VF_VehicleTest extends Elite_Vaf_TestCase
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
    
    function testShouldTrimWhitespaces2()
    {
        $this->createVehicle(array('make'=>'Honda ', 'model'=>'Civic', 'year'=>'2000'));
        $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>'2000'));
        
        $vehicles = $this->vehicleFinder()->findByLevels(array('year'=>'2000'));
        $this->assertEquals(1, count($vehicles));
    }

    function testToString()
    {
        $vehicle = $this->createMMY('Honda','Civic','2000');
        $this->assertEquals( 'Honda Civic 2000', $vehicle->__toString(), 'should convert vehicle to string');
    }

    function testToStringTemplate()
    {
        $vehicle = $this->createMMY('Honda','Civic','2000');
	$vehicle->setConfig(new Zend_Config(array('search'=>array('vehicleTemplate'=>'%make% %model%'))));
        $this->assertEquals( 'Honda Civic', $vehicle->__toString(), 'should convert vehicle to string');
    }

    function testLevelIdsTruncateAfter()
    {
        $vehicle = $this->createMMY('Honda','Civic','2000');
        $truncateAfter = $vehicle->levelIdsTruncateAfter('model');
        $this->assertEquals($vehicle->getValue('make'), $truncateAfter['make'] );
        $this->assertEquals($vehicle->getValue('model'), $truncateAfter['model'] );
        $this->assertFalse( isset($truncateAfter['year'] ) );
    }
}