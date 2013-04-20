<?php
class VF_LevelTests_PartialTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testInsertMakeCreatesPartialVehicle()
    {
        $level = new VF_Level('make');
        $level->setTitle('Honda');
        $level->save();
        
        $vehicles = $this->vehicleFinder()->findByLevels(array('make'=>'honda'),true);
        $this->assertEquals( 1, count($vehicles), 'should insert partial vehicle when inserting make');
    }
    
    function testInsertModelCreatesPartialVehicle()
    {
        $honda = new VF_Level('make');
        $honda->setTitle('Honda');
        $honda->save();
        
        $civic = new VF_Level('model');
        $civic->setTitle('Civic');
        $civic->save($honda->getId());
        
        $vehicles = $this->vehicleFinder()->findByLevels(array('make'=>'honda','model'=>'civic'),true);
        $this->assertEquals( 1, count($vehicles), 'should insert partial vehicle when inserting make');
    }
}