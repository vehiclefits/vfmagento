<?php
class VF_Level_FinderTests_FindEntityIdByTitleTest extends Elite_Vaf_TestCase
{
	function testRootLevel()
	{
		$originalVehicle = $this->createMMY('Honda');
		$makeId = $this->levelFinder()->findEntityIdByTitle('make','Honda');
		$this->assertEquals( $makeId, $originalVehicle->getValue('make'), 'should find root level by title' );
	}
	
	function testNonRootLevel()
	{
		$originalVehicle = $this->createMMY('Honda','Civic');
		$modelId = $this->levelFinder()->findEntityIdByTitle('model','Civic',$originalVehicle->getValue('make'));
		$this->assertEquals( $modelId, $originalVehicle->getValue('model'), 'should find non root level by title' );
	}
	
	function testShouldBeCaseSensitive()
	{
		$vehicle = $this->createMMY('Honda');
		$makeId = $this->levelFinder()->findEntityIdByTitle('make','honda');
		$this->assertFalse($makeId,'should be case sensitive');
	}
	
	function testShouldBeCaseSensitive2()
	{
		$vehicle = $this->createMMY('Honda');
		$makeId = $this->levelFinder()->findEntityIdByTitle('make','Honda');
		$this->assertTrue($makeId>0,'should be case sensitive');
	}
	
	function testShouldBeCaseSensitiveForModels()
	{
		$vehicle = $this->createMMY('Honda','Civic');
		$modelId = $this->levelFinder()->findEntityIdByTitle('model','civic',$vehicle->getValue('make'));
		$this->assertFalse($modelId,'should be case sensitive');
	}
	
	function testShouldBeCaseSensitiveForModels2()
	{
		$vehicle = $this->createMMY('Honda','Civic');
		$modelId = $this->levelFinder()->findEntityIdByTitle('model','Civic',$vehicle->getValue('make'));
		$this->assertTrue($modelId>0,'should be case sensitive');
	}
	
	function testShouldBeCaseSensitiveForYears()
	{
		$vehicle = $this->createMMY('Honda','Civic','Test');
		$yearId = $this->levelFinder()->findEntityIdByTitle('year','test',$vehicle->getValue('model'));
		$this->assertFalse($yearId,'should be case sensitive');
	}
	
	function testShouldBeCaseSensitiveForYears2()
	{
		$vehicle = $this->createMMY('Honda','Civic','Test');
		$yearId = $this->levelFinder()->findEntityIdByTitle('year','Test',$vehicle->getValue('model'));
		$this->assertTrue($yearId>0,'should be case sensitive');
	}
}