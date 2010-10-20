<?php
class Elite_Vaf_Model_Level_FinderTests_ExceptionTest extends Elite_Vaf_TestCase
{
	/**
	* @expectedException Elite_Vaf_Model_Level_Finder_SchemaException
	*/
	function testRootLevel()
	{
		$vehicle = $this->createMMY('Honda','Civic','2000');
		$this->levelFinder()->findEntityIdByTitle('model','civic');
	}
}