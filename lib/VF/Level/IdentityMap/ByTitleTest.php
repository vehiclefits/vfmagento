<?php
class VF_Level_IdentityMap_ByTitleTest extends Elite_Vaf_TestCase
{
    function testPrefixingZero()
    {
        $identityMap = new VF_Level_IdentityMap_ByTitle();
        $identityMap->add(1,'make','01');
        $this->assertFalse( $identityMap->has('make','1'));
    }
    
    function testPrefixingZero2()
    {
        $identityMap = new VF_Level_IdentityMap_ByTitle();
        $identityMap->add(1,'make','01');
        $this->assertFalse( $identityMap->get('make','1'));
    }
}