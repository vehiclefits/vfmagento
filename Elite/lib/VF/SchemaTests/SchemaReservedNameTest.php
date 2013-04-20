<?php
class VF_SchemaTests_SchemaReservedNameTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,version');
    }
    
    function testLevels()
    {
        $schema = new VF_Schema();
        $this->assertEquals( array( 'make','model','version'), $schema->getLevels(), 'should get levels' );
    }
}
