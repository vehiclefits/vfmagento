<?php
class VF_SchemaTests_SchemaFOOTest extends Elite_Vaf_TestCase
{
	function doSetUp()
	{
		$this->switchSchema('foo,bar');
	}
	
	function testLevelsFB()
    {
        $schema = new VF_Schema();
        $this->assertEquals( array('foo','bar'), $schema->getLevels(), 'should get levels FB' );
    }
}
