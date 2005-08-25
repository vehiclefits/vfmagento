<?php
class VF_SchemaTests_MMY_NextLevelsIncludingTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testNextLevelsYear()
    {
        $schema = new VF_Schema(); 
        $this->assertEquals( array('year'), $schema->getNextLevelsIncluding('year') );
    }
    
    function testNextLevelsModel()
    {
        $schema = new VF_Schema(); 
        $this->assertEquals( array('model','year'), $schema->getNextLevelsIncluding('model') );
    }
    
    function testNextLevelsMake()
    {
        $schema = new VF_Schema(); 
        $this->assertEquals( array('make','model','year'), $schema->getNextLevelsIncluding('make') );
    }
}