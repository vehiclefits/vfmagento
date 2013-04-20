<?php
class Elite_Vaftire_Model_FinderTests_DiameterTest extends Elite_Vaf_TestCase
{
    function testShouldFindAll()
    {
        $this->newTireProduct(1, new Elite_Vaftire_Model_TireSize(null,null,16));
        $this->assertEquals( array(16=>16), $this->tireFinder()->diameters(), 'should find possible diameter' );
    }

    function testShouldSort()
    {
        $this->newTireProduct(1, new Elite_Vaftire_Model_TireSize(null,null,18));
        $this->newTireProduct(2, new Elite_Vaftire_Model_TireSize(null,null,15));
        $this->assertEquals( array(15=>15, 18=>18), $this->tireFinder()->diameters(), 'should sort diameter' );
    }
}