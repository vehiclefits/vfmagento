<?php
class Elite_Vafwheel_Model_BoltPatternTest extends Elite_Vaf_TestCase
{
    
    function testSingleToString()
    {
        $bolt = Elite_Vafwheel_Model_BoltPattern::create('4x114.3');
        $this->assertEquals( '4x114.3', $bolt->__toString() );
    }
    
    function testSingleLugCount()
    {
        $bolt = Elite_Vafwheel_Model_BoltPattern::create('4x114.3');
        $this->assertEquals( 4, $bolt->getLugCount() );
    }
    
    function testSingleBoltDistance()
    {
        $bolt = Elite_Vafwheel_Model_BoltPattern::create('4x114.3');
        $this->assertEquals( 114.3, $bolt->getDistance() );
    }
}