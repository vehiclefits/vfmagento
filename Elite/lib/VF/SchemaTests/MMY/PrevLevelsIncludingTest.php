<?php
class VF_SchemaTests_MMY_PrevLevelsIncludingTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testPrevLevelsIncludingMake()
    {
        $schema = new VF_Schema(); 
        $this->assertEquals( array('make'), $schema->getPrevLevelsIncluding('make') );
    }
    
    function testPrevLevelsIncludingsModel()
    {
        $schema = new VF_Schema(); 
        $this->assertEquals( array('make','model'), $schema->getPrevLevelsIncluding('model') );
    }
    
    function testPrevLevelssIncludingYear()
    {
        $schema = new VF_Schema(); 
        $this->assertEquals( array('make','model','year'), $schema->getPrevLevelsIncluding('year') );
    }
}