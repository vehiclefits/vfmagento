<?php

class VF_Vehicle_FinderTests_ByLevelsTest extends VF_Vehicle_FinderTests_TestCase
{
	function testShouldThrowExceptionForInvalidLevel()
    {
        return $this->markTestIncomplete();
    }
    
    function testShouldFindByAllLevels()
    {
        $this->createMMY( 'Honda', 'Civic', '2000' );
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'Honda','model'=>'Civic','year'=>2000));
        $this->assertEquals(1,count($vehicles),'should find by levels');
    }
    
    function testFindOneByLevelsNotFound()
    {
        $vehicle = $this->getFinder()->findOneByLevels( array('make'=>'Honda','year'=>'2000'));
        $this->assertFalse($vehicle,'when vehicle is not found should return false');
    }
    
    function testShouldFindOneByLevels()
    {
        $this->createMMY( 'Honda', 'Civic', '2000' );
        $vehicle = $this->getFinder()->findOneByLevels( array('make'=>'Honda','model'=>'Civic','year'=>2000));
        $this->assertEquals( 'Honda Civic 2000', (string)$vehicle, 'should find one vehicle by levels');
    }
    
    function testShouldFindByMakeAndYear()
    {
	$this->createMMY( 'Not Honda', 'Civic', '2000' );
        $this->createMMY( 'Honda', 'Accord', '2000' );
        $this->createMMY( 'Honda', 'Accord', '6666' );
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'Honda','year'=>'2000'));
        $this->assertEquals(1,count($vehicles),'should find by make & year');
    }
    
    function testShouldExcludeDifferentMake()
    {
        $this->createMMY( 'Honda', 'Civic', '2000' );
        $this->createMMY( 'Not Honda', 'Civic', '2000' );
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'Honda'));
        $this->assertEquals(1,count($vehicles),'should exclude different makes');
    }
    
    function testShouldExcludeDifferentModel()
    {
        $this->createMMY( 'Honda', 'Civic', '2000' );
        $this->createMMY( 'Honda', 'Accord', '2000' );
        $vehicles = $this->getFinder()->findByLevels( array('model'=>'Accord'));
        $this->assertEquals(1,count($vehicles),'should exclude different models');
    }
    
    function testShouldExcludeDifferentMakeAndYear()
    {
        $this->createMMY( 'Not Honda', 'Civic', '2000' );
        $this->createMMY( 'Honda', 'Accord', '2000' );
        $this->createMMY( 'Honda', 'Accord', '6666' );
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'Honda','year'=>'2000'));
        $this->assertEquals(1,count($vehicles),'should exclude different make & year');
    }
    
    function testShouldFindPartialVehicleMake()
    {
        $make = new VF_Level('make');
        $make->setTitle('Honda');
        $make->save();
        
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'Honda'), true );
        $this->assertEquals(1,count($vehicles),'should find partial vehicle by make');
    }

    function testPartialVehicleShouldHaveMakeID()
    {
        $make = new VF_Level('make');
        $make->setTitle('Honda');
        $make->save();
        
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'Honda'), true );
        $this->assertEquals( $make->getId(), $vehicles[0]->getValue('make'), 'partial vehicle should have make ID');
        $this->assertEquals( 0, $vehicles[0]->getValue('model'), 'partial vehicle should have no model ID');
    }
    
    function testShouldEscapeRegex()
    {
        $make = new VF_Level('make');
        $make->setTitle('.\+');
        $make->save();
        
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'.\+'), true );
        $this->assertEquals(1,count($vehicles),'should escape regex');
    }
    
    
    function testShouldEscapeRegex2()
    {
        $make = new VF_Level('make');
        $make->setTitle('?[^]$');
        $make->save();
        
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'?[^]$'), true );
        $this->assertEquals(1,count($vehicles),'should escape regex');
    }
    
    function testShouldEscapeRegex3()
    {
        $make = new VF_Level('make');
        $make->setTitle('(){}=!');
        $make->save();
        
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'(){}=!'), true );
        $this->assertEquals(1,count($vehicles),'should escape regex');
    }
    
    function testShouldEscapeRegex4()
    {
        $make = new VF_Level('make');
        $make->setTitle(':-');
        $make->save();
        
        $vehicles = $this->getFinder()->findByLevels( array('make'=>':-'), true );
        $this->assertEquals(1,count($vehicles),'should escape regex');
    }
    
    function testShouldEscapeRegex5()
    {
        $make = new VF_Level('make');
        $make->setTitle('.\+*?[^]$(){}=!<>|:-');
        $make->save();
        
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'.\+*?[^]$(){}=!<>|:-'), true );
        $this->assertEquals(1,count($vehicles),'should escape regex');
    }
    
    function testShouldIgnoreUnknownLevels()
    {
        $vehicles = $this->getFinder()->findByLevels( array('foo'=>'bar') );
        $this->assertEquals( 0, count($vehicles));
    }
}