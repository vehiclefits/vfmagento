<?php
class VF_Vehicle_FinderTests_ByLevelsWithDashesTest extends VF_Vehicle_FinderTests_TestCase
{
	function testWithoutDash()
    {
        $this->createMMY( 'Honda', 'All Models', '2000' );
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'Honda','model'=>'All Models','year'=>2000));
        $this->assertEquals(1,count($vehicles));
    }
    
    function testShouldReplaceDashesWithSpaces()
    {
        $this->createMMY( 'Honda', 'All Models', '2000' );
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'Honda','model'=>'All-Models','year'=>2000));
        $this->assertEquals(1,count($vehicles),'should replace dashes with spaces');
    }
    
    function testShouldExcludeDifferentYear()
    {
        $this->createMMY( 'Honda', 'All-Models', '2001' );
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'Honda','model'=>'All-Models','year'=>2000));
        $this->assertEquals(0,count($vehicles),'should exclude different years');
    }
    
    function testShouldExcludeDifferentModel()
    {
        $this->createMMY( 'Honda', 'All-Models', '2001' );
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'Honda','model'=>'All-','year'=>2001));
        $this->assertEquals(0,count($vehicles),'should exclude different models');
    }
    
    function testShouldExcludeDifferentModel2()
    {
        $this->createMMY( 'Honda', 'All-Models', '2001' );
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'Honda','model'=>'-Models','year'=>2001));
        $this->assertEquals(0,count($vehicles),'should exclude different models');
    }
    
    function testShouldInterchangeDashAndSpaces()
    {
        $this->createMMY( 'Ford', 'F-150 Super Duty', '2000' );
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'Ford','model'=>'F-150 Super-Duty','year'=>2000));
        $this->assertEquals(1,count($vehicles),'should interchange dashes & spaces');
    }
    
}