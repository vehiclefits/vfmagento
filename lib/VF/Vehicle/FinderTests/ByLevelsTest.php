<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

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
        $vehicle = $this->createVehicle(array('make'=>'Honda'));
        $make = $vehicle->getLevel('make');
        
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'Honda'), true );
        $this->assertEquals(1,count($vehicles),'should find partial vehicle by make');
    }

    function testPartialVehicleShouldHaveMakeID()
    {
        $vehicle = $this->createMMY('Honda', 'Civic', '2000');
        $make = $vehicle->getLevel('make');
        
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'Honda'), true );

        $this->assertEquals( $make->getId(), $vehicles[0]->getValue('make'), 'partial vehicle should have make ID');
        $this->assertEquals( 0, $vehicles[0]->getValue('model'), 'partial vehicle should have no model ID');
    }
    
    function testShouldEscapeRegex()
    {
        $this->createMMY('.\+', 'Civic', '2000');
        
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'.\+'), true );
        $this->assertEquals(1,count($vehicles),'should escape regex');
    }
    
    
    function testShouldEscapeRegex2()
    {
        $this->createMMY('?[^]$', 'Civic', '2000');
        
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'?[^]$'), true );
        $this->assertEquals(1,count($vehicles),'should escape regex');
    }
    
    function testShouldEscapeRegex3()
    {
        $this->createMMY('(){}=!', 'Civic', '2000');

        $vehicles = $this->getFinder()->findByLevels( array('make'=>'(){}=!'), true );
        $this->assertEquals(1,count($vehicles),'should escape regex');
    }
    
    function testShouldEscapeRegex4()
    {
        $this->createMMY(':-', 'Civic', '2000');

        $vehicles = $this->getFinder()->findByLevels( array('make'=>':-'), true );
        $this->assertEquals(1,count($vehicles),'should escape regex');
    }
    
    function testShouldEscapeRegex5()
    {
        $this->createMMY('.\+*?[^]$(){}=!<>|:-', 'Civic', '2000');
        
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'.\+*?[^]$(){}=!<>|:-'), true );
        $this->assertEquals(1,count($vehicles),'should escape regex');
    }
    
    function testShouldIgnoreUnknownLevels()
    {
        $vehicles = $this->getFinder()->findByLevels( array('foo'=>'bar') );
        $this->assertEquals( 0, count($vehicles));
    }
}