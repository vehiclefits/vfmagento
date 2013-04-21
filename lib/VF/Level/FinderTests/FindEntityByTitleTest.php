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
class VF_Level_FinderTests_FindEntityByTitleTest extends Elite_Vaf_TestCase
{
	function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testNotFound()
    {
        $make = $this->levelFinder()->findEntityByTitle('make','Honda');
        $this->assertFalse( $make, 'should return false when not found' );
    }

    function testRootLevel()
    {
        $originalVehicle = $this->createMMY('Honda');
        $make = $this->levelFinder()->findEntityByTitle('make','Honda');
        $this->assertEquals( $make->getId(), $originalVehicle->getValue('make'), 'should find root level\'s ID by title' );
    }

    function testNonRootLevel()
    {
        $originalVehicle = $this->createMMY('Honda','Civic');
        $model = $this->levelFinder()->findEntityByTitle('model','Civic',$originalVehicle->getValue('make'));
        $this->assertEquals( $model->getId(), $originalVehicle->getValue('model'), 'should find non root level\'s ID by title' );
    }

    function testShouldBeCaseSensitive()
    {
        $vehicle = $this->createMMY('Honda');
        $make = $this->levelFinder()->findEntityByTitle('make','honda');
        $this->assertFalse($make,'should be case sensitive');
    }

    function testShouldBeCaseSensitive2()
    {
        $vehicle = $this->createMMY('Honda');
        $make = $this->levelFinder()->findEntityByTitle('make','Honda');
        $this->assertTrue($make->getId() > 0, 'should be case sensitive');
    }

    function testShouldBeCaseSensitiveForModels()
    {
        $vehicle = $this->createMMY('Honda','Civic');
        $model = $this->levelFinder()->findEntityByTitle('model','civic',$vehicle->getValue('make'));
        $this->assertFalse($model,'should be case sensitive');
    }

    function testShouldBeCaseSensitiveForModels2()
    {
        $vehicle = $this->createMMY('Honda','Civic');
        $model = $this->levelFinder()->findEntityByTitle('model','Civic',$vehicle->getValue('make'));
        $this->assertTrue($model->getId()>0,'should be case sensitive');
    }

    function testShouldBeCaseSensitiveForYears()
    {
        $vehicle = $this->createMMY('Honda','Civic','Test');
        $year = $this->levelFinder()->findEntityByTitle('year','test',$vehicle->getValue('model'));
        $this->assertFalse($year,'should be case sensitive');
    }

    function testShouldBeCaseSensitiveForYears2()
    {
        $vehicle = $this->createMMY('Honda','Civic','Test');
        $year = $this->levelFinder()->findEntityByTitle('year','Test',$vehicle->getValue('model'));
        $this->assertTrue($year->getId() > 0,'should be case sensitive');
    }
}