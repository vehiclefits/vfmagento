<?php
class Elite_Vafsitemap_Model_DashBruteForceTest extends Elite_Vaf_TestCase
{
    function testBrute1()
    {
        return $this->markTestIncomplete();
        $input = 'F-F';
        $this->assertEquals( array('F-F', 'F F'), $this->bruteForce($input), 'should find possible combinations of dashes & spaces for one "slot"' );
    }
    
    function testBrute2()
    {
        return $this->markTestIncomplete();
        $input = 'F-F-F';
        $this->assertEquals( array('F-F-F', 'F F F', 'F-F F', 'F F-F', 'F F F'), $this->bruteForce($input), 'should find possible combinations of dashes & spaces for two "slot"' );
    }
    
    function bruteForce($input)
    {
        $brute = new Elite_Vafsitemap_Model_DashBruteForce;
        return $brute->bruteForce($input);
    }
}