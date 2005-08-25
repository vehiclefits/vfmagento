<?php
class VF_SchemaTests_SchemaMMOYTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
		$this->switchSchema('make,model,option,year');
    }
    
    function testLevelsMMOY()
    {
        $schema = new VF_Schema();
        $this->assertEquals( array('make','model','option','year'), $schema->getLevels(), 'should get levels MMOY' );
    }
}
