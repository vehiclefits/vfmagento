<?php
class VF_LevelTests_EditTest extends Elite_Vaf_TestCase
{
	function doSetUp()
	{
		$this->switchSchema('make,model,year');
	}
	
    function testShouldEditLevel()
    {
        $make = $this->createMMY('Honda','Civic','2000')->getLevel('make');
        $make->setTitle('honda')->save();
        $make = $this->findMakeById($make->getId());
        $this->assertEquals('honda',$make->getTitle(),'should be able to change the case of a level');
    }
    
    function testShouldEditNotCopyMake()
    {
        $make = $this->createMMY('a','Civic','2000')->getLevel('make');
        $make->setTitle('b')->save();
        $this->assertFalse($this->vehicleExists(array('make'=>'a')), 'should edit not copy the old make');
    }
    
    function testShouldEditNotCopyModel()
    {
        $vehicle = $this->createMMY('Honda','a','2000');
        $vehicle->getLevel('model')->setTitle('b')->save($vehicle->getValue('make'));
        $this->assertFalse($this->vehicleExists(array('model'=>'a')), 'should edit not copy the old model');
    }
    
    
	function testShouldEditNotCopyModel2()
	{
		$vehicle = $this->createMMY('Honda','a','2000');
        $vehicle->getLevel('model')->setTitle('b')->save($vehicle->toValueArray());
		$this->assertFalse($this->vehicleExists(array('model'=>'a')), 'should edit not copy the old model');
	}
	
	/**
	* @expectedException Exception
	*/
	function testShouldNotAllowBlankTitle()
	{
		$make = $this->createMMY('Honda','Civic','2000')->getLevel('make');
		$make->setTitle('')->save();
	}
	
	/**
	* @expectedException Exception
	*/
	function testShouldNotAllowBlankTitle2()
	{
		$make = $this->createMMY('Honda','Civic','2000')->getLevel('make');
		$make->setTitle(' ')->save();
	}
}