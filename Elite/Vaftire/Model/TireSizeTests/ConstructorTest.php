<?php
class Elite_Vaftire_Model_TireSizeTests_ConstructorTest extends Elite_Vaf_TestCase
{
    function testSectionWidth()
    {
        $tireSize = new Elite_Vaftire_Model_TireSize(205,null,null);
        $this->assertEquals(205,$tireSize->sectionWidth(),'tire size has a section width');
    }
    
    function testAspectRatio()
    {
        $tireSize = new Elite_Vaftire_Model_TireSize(null,55,null);
        $this->assertEquals(55,$tireSize->aspectRatio(),'tire size has an aspect ratio');
    }
    
    function testDiameter()
    {
        $tireSize = new Elite_Vaftire_Model_TireSize(null,null,16);
        $this->assertEquals(16,$tireSize->diameter(),'tire size has a diameter');
    }
    
    function testShouldFormatString()
    {
        $tireSize = new Elite_Vaftire_Model_TireSize(205,55,16);
        $this->assertEquals( '205/55-16', (string)$tireSize, 'should format a tire size string' );
    }
    
}