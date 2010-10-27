<?php
class Elite_Vaf_Model_Vehicle_FinderTests_ByLevelsIdsTest extends Elite_Vaf_Model_Vehicle_FinderTests_TestCase
{
	function testShouldFindByAllLevels()
    {
        $vehicle = $this->createMMY( 'Honda', 'Civic', '2000' );
        $vehicles = $this->getFinder()->findByLevelIds( $vehicle->toValueArray() );
        $this->assertEquals(1,count($vehicles),'should find by levels');
    }
    
    function testShouldFindByMake()
    {
        $vehicle = $this->createMMY( 'Honda', 'Civic', '2000' );
        $vehicles = $this->getFinder()->findByLevelIds( array('make'=>$vehicle->getValue('make')) );
        $this->assertEquals(1,count($vehicles),'should find by make');
    }
    
    function testShouldFindByMakeAlternateParamaterStyle()
    {
        $vehicle = $this->createMMY( 'Honda', 'Civic', '2000' );
        $vehicles = $this->getFinder()->findByLevelIds( array('make_id'=>$vehicle->getValue('make')) );
        $this->assertEquals(1,count($vehicles),'should find by make w/ alternative paramater style (make_id)');
    }
    
    function testShouldFindPartialVehicleMake()
    {
        $make = new Elite_Vaf_Model_Level('make');
        $make->setTitle('Honda');
        $make->save();
        
        $vehicles = $this->getFinder()->findByLevelIds( array('make'=>$make->getId()), true );
        $this->assertEquals(1,count($vehicles),'should find partial vehicle by make');
    }
    
    function testShouldFindPartialVehicleMake2()
    {
        $vehicle = $this->createMMY('Honda','Civic','2000');
        $make = $vehicle->getLevel('make');
        
        $vehicles = $this->getFinder()->findByLevelIds( array('make'=>$make->getId()), true );
        $this->assertEquals(3,count($vehicles),'should find partial vehicle by make');
    }
    
    function testPartialVehicleShouldHaveMakeID()
    {
        $make = new Elite_Vaf_Model_Level('make');
        $make->setTitle('Honda');
        $make->save();
        
        $vehicles = $this->getFinder()->findByLevelIds( array('make'=>$make->getId()), true );
        $this->assertEquals( $make->getId(), $vehicles[0]->getValue('make'), 'partial vehicle should have make ID');
    }
    
    function testZeroShouldMatchPartialVehicle()
    {
        $make = new Elite_Vaf_Model_Level('make');
        $make->setTitle('Honda');
        $make->save();
        
        $vehicles = $this->getFinder()->findByLevelIds( array('make'=>$make->getId(), 'model'=>0, 'year'=>0), true );
        $this->assertEquals( 1, count($vehicles), 'zero should match partial vehicle');
    }
    
    function testZeroShouldExcludeFullVehicle()
    {
        $vehicle = $this->createMMY('Honda','Civic','2000');
        
        $vehicles = $this->getFinder()->findByLevelIds( array('make'=>$vehicle->getValue('make'), 'model'=>0, 'year'=>0) );
        $this->assertEquals( 0, count($vehicles), 'zero should exclude full vehicles');
    }
    
}