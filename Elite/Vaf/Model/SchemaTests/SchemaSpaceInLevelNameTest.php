<?php
class Elite_Vaf_Model_SchemaTests_SchemaSpaceInLevelNameTest extends Elite_Vafimporter_TestCase
{
    function doSetUp()
    {
	$this->switchSchema('make,model type,year');
    }
    
    function testLevels()
    {
        $schema = new Elite_Vaf_Model_Schema();
        $this->assertEquals( array('make','model type','year'), $schema->getLevels(), 'should allow spaces in level name' );
    }

    function testImport()
    {
	return $this->markTestIncomplete();
	
	$this->importVehiclesList('make,model type, year' . "\n" .
		'Honda, Civic EX, 2000' );
    }
}
