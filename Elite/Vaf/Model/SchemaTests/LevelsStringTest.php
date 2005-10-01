<?php

class Elite_Vaf_Model_SchemaTests_LevelsStringTest extends Elite_Vaf_TestCase
{

    function doSetUp()
    {
	$this->switchSchema('foo,bar');
    }

    function testLevelsFB()
    {
	$schema = new Elite_Vaf_Model_Schema();
	$this->assertEquals('`foo`,`bar`', $schema->getLevelsString(), 'should escape levels for mysql');
    }

}
