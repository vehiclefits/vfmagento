<?php
class Elite_Vaftire_Model_TireSizeTests_FormattedStringTest extends Elite_Vaf_TestCase
{
    
    function testShouldCreateFromFormattedString()
    {
        $tireSize = Elite_Vaftire_Model_TireSize::create('205/55-16');
        $this->assertEquals( '205/55-16', (string)$tireSize, 'should format a tire size string' );
    }
    
    /**
    * @expectedException Elite_Vaftire_Model_TireSize_InvalidFormatException
    */
    function testShouldThrowExceptionForMissingSectionWidth()
    {
        $tireSize = Elite_Vaftire_Model_TireSize::create('/55-16');
    }
    
    /**
    * @expectedException Elite_Vaftire_Model_TireSize_InvalidFormatException
    */
    function testShouldThrowExceptionForMissingAspectRatio()
    {
        $tireSize = Elite_Vaftire_Model_TireSize::create('205/-16');
    }
    
    /**
    * @expectedException Elite_Vaftire_Model_TireSize_InvalidFormatException
    */
    function testShouldThrowExceptionForMissingOutsideDiameter()
    {
        $tireSize = Elite_Vaftire_Model_TireSize::create('205/55-');
    }
    
}