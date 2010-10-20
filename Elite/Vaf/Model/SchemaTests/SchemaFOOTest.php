<?php
class Elite_Vaf_Model_SchemaTests_SchemaFOOTest extends Elite_Vaf_TestCase
{
	function doSetUp()
	{
		$this->switchSchema('foo,bar');
	}
	
	function testLevelsFB()
    {
        $schema = new Elite_Vaf_Model_Schema();
        $this->assertEquals( array('foo','bar'), $schema->getLevels(), 'should get levels FB' );
    }
}
