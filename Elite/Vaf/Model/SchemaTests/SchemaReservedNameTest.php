<?php
class Elite_Vaf_Model_SchemaTests_SchemaReservedNameTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,version');
    }
    
    function testLevels()
    {
        $schema = new Elite_Vaf_Model_Schema();
        $this->assertEquals( array( 'make','model','version'), $schema->getLevels(), 'should get levels' );
    }
}
