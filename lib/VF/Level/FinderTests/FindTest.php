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
class VF_Level_FinderTests_FindTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testShouldLoadMakeId()
    {
        $vehicle = $this->createMMY();
        $make_reloaded = $this->levelFinder()->find('make',$vehicle->getValue('make'));
        $this->assertEquals( $vehicle->getValue('make'), $make_reloaded->getId(), 'should load make id' );
    }
    
    function testShouldLoadMakeTitle()
    {
        $vehicle = $this->createMMY('Honda');
        $make_reloaded = $this->levelFinder()->find('make',$vehicle->getValue('make'));
        $this->assertEquals( 'Honda', $make_reloaded->getTitle(), 'should load make title' );
    }
    
    function testShouldLoadModelId()
    {
        $vehicle = $this->createMMY();
        $model_reloaded = $this->levelFinder()->find('model',$vehicle->getValue('model'));
        $this->assertEquals( $vehicle->getValue('model'), $model_reloaded->getId(), 'should load model id' );
    }
    
    function testShouldLoadModelTitle()
    {
        $vehicle = $this->createMMY('Honda','Civic');
        $model_reloaded = $this->levelFinder()->find('model',$vehicle->getValue('model'));
        $this->assertEquals( 'Civic', $model_reloaded->getTitle(), 'should load model title' );
    }
    
    function testShouldLoadYearId()
    {
        $vehicle = $this->createMMY();
        $year_reloaded = $this->levelFinder()->find('year',$vehicle->getValue('year'));
        $this->assertEquals( $vehicle->getValue('year'), $year_reloaded->getId(), 'should load year id' );
    }
    
    function testShouldLoadYearTitle()
    {
        $vehicle = $this->createMMY('Honda','Civic','2000');
        $year_reloaded = $this->levelFinder()->find('year',$vehicle->getValue('year'));
        $this->assertEquals( '2000', $year_reloaded->getTitle(), 'should load year title' );
    }
    
    function testShouldLoadMultipleMake()
    {
        $vehicle1 = $this->createMMY();
        $vehicle2 = $this->createMMY();
        $make_reloaded = $this->levelFinder()->find('make',$vehicle1->getValue('make'));;
        $make_reloaded2 = $this->levelFinder()->find('make',$vehicle2->getValue('make'));
        $this->assertEquals( $vehicle1->getValue('make'), $make_reloaded->getId() );
        $this->assertEquals( $vehicle2->getValue('make'), $make_reloaded2->getId(), 'should load multiple make' );
    }
    
    function testShouldLoadMultipleModel()
    {
        $vehicle1 = $this->createMMY();
        $vehicle2 = $this->createMMY();
        $model_reloaded = new VF_Level('model',$vehicle1->getValue('model'));
        $model_reloaded2 = new VF_Level('model',$vehicle2->getValue('model'));
        $this->assertEquals( $vehicle1->getValue('model'), $model_reloaded->getId() );
        $this->assertEquals( $vehicle2->getValue('model'), $model_reloaded2->getId(), 'should load multiple model' );
    }
    
    function testShouldLoadMultipleYear()
    {
        $vehicle1 = $this->createMMY();
        $vehicle2 = $this->createMMY();
        $year_reloaded = new VF_Level('year',$vehicle1->getValue('year'));
        $year_reloaded2 = new VF_Level('year',$vehicle2->getValue('year'));
        $this->assertEquals( $vehicle1->getValue('year'), $year_reloaded->getId() );
        $this->assertEquals( $vehicle2->getValue('year'), $year_reloaded2->getId(), 'should load multiple year' );
    }

}