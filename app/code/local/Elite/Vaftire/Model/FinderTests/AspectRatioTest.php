<?php
class Elite_Vaftire_Model_FinderTests_AspectRatioTest extends Elite_Vaf_TestCase
{
	function testShouldFindAll()
    {
        $this->newTireProduct(1, new Elite_Vaftire_Model_TireSize(null,55,null));
        $this->assertEquals( array(55=>55), $this->tireFinder()->aspectRatios(), 'should find possible aspect ratios' );
    }

    function testShouldSort()
    {
        $this->newTireProduct(1, new Elite_Vaftire_Model_TireSize(null,65,null));
        $this->newTireProduct(2, new Elite_Vaftire_Model_TireSize(null,55,null));
        $this->assertEquals( array(55=>55, 65=>65), $this->tireFinder()->aspectRatios(), 'should sort aspect ratios' );
    }
}