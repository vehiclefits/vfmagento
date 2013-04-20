<?php
class Elite_Vaftire_Model_FinderTests_SectionWidthTest extends Elite_Vaf_TestCase
{
    function testFindAll()
    {
        $this->newTireProduct(1, new Elite_Vaftire_Model_TireSize(205,null,null));
        $this->assertEquals( array(205=>205), $this->tireFinder()->sectionWidths(), 'should find possible section widths' );
    }
	
	function testShouldSort()
    {
        $this->newTireProduct(1, new Elite_Vaftire_Model_TireSize(205,null,null));
        $this->newTireProduct(2, new Elite_Vaftire_Model_TireSize(150,null,null));
      
	}
}