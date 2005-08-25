<?php
class Elite_Vaf_Model_Vehicle_Finder_IdentityMapTest extends Elite_Vaf_TestCase
{
    function testWhenHasNoVehicles()
    {
        $this->assertFalse($this->identityMap()->has(1), 'when identity map has no vehicles, should return false for has()' );
    }
    
    function identityMap()
    {
        return new Elite_Vaf_Model_Vehicle_Finder_IdentityMap;
    }
}