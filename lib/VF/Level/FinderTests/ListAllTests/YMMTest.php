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
class VF_Level_FinderTests_ListAllTests_YMMTest extends Elite_Vaf_TestCase
{
    protected function doSetUp()
    {
        $this->switchSchema('year,make,model');
    }
    
    function testFindsDistinctResults()
    {
        $vehicle1 = $this->createVehicle(array('year'=>2000, 'make'=>'Honda', 'model'=>'Civic'));
        $vehicle2 = $this->createVehicle(array('year'=>2001, 'make'=>'Honda', 'model'=>'Civic'));
        
        $actual = $this->levelFinder()->listAll('make', $vehicle1->getValue('year'));
        $this->assertEquals( 1, count($actual), 'should find distinct makes');
    }
        
    function testFindsDistinctResults2()
    {
        $vehicle1 = $this->createVehicle(array('year'=>2000, 'make'=>'Honda', 'model'=>'Civic'));
        $vehicle2 = $this->createVehicle(array('year'=>2000, 'make'=>'Honda', 'model'=>'Accord'));
        
        $actual = $this->levelFinder()->listAll('make', $vehicle1->getValue('year'));
        $this->assertEquals( 1, count($actual), 'should find distinct makes');
    }

    function testShouldFindDistinctMakesOnly()
    {
        $vehicle1 = $this->createVehicle(array('year'=>2001, 'make'=>'Honda', 'model'=>'Civic'));
        $vehicle2 = $this->createVehicle(array('year'=>2000, 'make'=>'Honda', 'model'=>'Civic'));

        $actual = $this->levelFinder()->listAll('make');
        $this->assertEquals( 1, count($actual), 'should find distinct makes only');
    }
}