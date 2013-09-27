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
 * to sales@vehiclefits.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Elite_Vaf_Model_MergeTests_TireTest extends Elite_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
	function testShouldAllowOperation()
    {
        $tireSize = Elite_Vaftire_Model_TireSize::create('205/55-16');
    	$vehicle1 = $this->createTireMMY('Honda','Civic','2000');
        $vehicle1->addTireSize( $tireSize );
        
        $vehicle2 = $this->createTireMMY('Honda','Civic','2001');
        $vehicle2->addTireSize( $tireSize );
        
        $slaveLevels = array(
            array('year', $vehicle1->vehicle() ),
            array('year', $vehicle2->vehicle() ),
        );
        $masterLevel = array('year', $vehicle2->vehicle() );
        
        $this->merge($slaveLevels, $masterLevel);
        
        $actual = $vehicle2->tireSize();
        $this->assertEquals($tireSize, $actual[0]);
    }
    
	/**
	 * @expectedException Elite_Vaf_Model_Merge_Exception_IncompatibleVehicleAttribute
	 */
	function testShouldPreventOperation()
    {
        $vehicle1 = $this->createTireMMY('Honda','Civic','2000');
        $vehicle1->addTireSize( Elite_Vaftire_Model_TireSize::create('205/55-16') );
        
        $vehicle2 = $this->createTireMMY('Honda','Civic','2001');
        $vehicle2->addTireSize( Elite_Vaftire_Model_TireSize::create('205/55-17') );
        
        $slaveLevels = array(
            array('year', $vehicle1->vehicle() ),
            array('year', $vehicle2->vehicle() ),
        );
        $masterLevel = array('year', $vehicle2->vehicle() );
        
        $this->merge($slaveLevels, $masterLevel);
    }
    
	/**
	 * @expectedException Elite_Vaf_Model_Merge_Exception_IncompatibleVehicleAttribute
	 */
	function testShouldPreventOperation2()
    {
        $vehicle1 = $this->createTireMMY('Honda','Civic','2000');
        $vehicle1->addTireSize( Elite_Vaftire_Model_TireSize::create('205/55-16') );
        
        $vehicle2 = $this->createTireMMY('Honda','Civic','2001');
        $vehicle2->addTireSize( Elite_Vaftire_Model_TireSize::create('205/56-16') );
        
        $slaveLevels = array(
            array('year', $vehicle1->vehicle() ),
            array('year', $vehicle2->vehicle() ),
        );
        $masterLevel = array('year', $vehicle2->vehicle() );
        
        $this->merge($slaveLevels, $masterLevel);
    }
    
	/**
	 * @expectedException Elite_Vaf_Model_Merge_Exception_IncompatibleVehicleAttribute
	 */
	function testShouldPreventOperation3()
    {
        $vehicle1 = $this->createTireMMY('Honda','Civic','2000');
        $vehicle1->addTireSize( Elite_Vaftire_Model_TireSize::create('205/55-16') );
        
        $vehicle2 = $this->createTireMMY('Honda','Civic','2001');
        $vehicle2->addTireSize( Elite_Vaftire_Model_TireSize::create('204/55-16') );
        
        $slaveLevels = array(
            array('year', $vehicle1->vehicle() ),
            array('year', $vehicle2->vehicle() ),
        );
        $masterLevel = array('year', $vehicle2->vehicle() );
        
        $this->merge($slaveLevels, $masterLevel);
    }
}