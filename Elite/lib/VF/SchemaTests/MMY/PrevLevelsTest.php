<?php
class VF_SchemaTests_MMY_PrevLevelsTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testPrevLevelsMake()
    {
        $schema = new VF_Schema(); 
        $this->assertEquals( array(), $schema->getPrevLevels('make') );
    }
    
    function testPrevLevelsModel()
    {
        $schema = new VF_Schema(); 
        $this->assertEquals( array('make'), $schema->getPrevLevels('model') );
    }
    
    function testPrevLevelsYear()
    {
        $schema = new VF_Schema(); 
        $this->assertEquals( array('make','model'), $schema->getPrevLevels('year') );
    }
}