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
class Elite_Vaftire_Model_FlexibleSearchTests extends Elite_Vaf_TestCase
{

    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testShouldSelectAspectRatio()
    {
        $vehicle = $this->createTireMMY('Honda','Civic','2000');
        $vehicle->addTireSize( Elite_Vaftire_Model_TireSize::create('205/55-16') );
        
        $search = $this->flexibleTireSearch($vehicle->toValueArray());
	$search->setConfig( new Zend_Config(array('tire'=>array('populateWhenSelectVehicle'=>'true'))));
        $this->assertEquals( 55, $search->aspectRatio(), 'should preselect aspect ratio when selecting vehicle');
    }
       
    function testShouldSelectSectionWidth()
    {
        $vehicle = $this->createTireMMY('Honda','Civic','2000');
        $vehicle->addTireSize( Elite_Vaftire_Model_TireSize::create('205/55-16') );
        
        $search = $this->flexibleTireSearch($vehicle->toValueArray());
	$search->setConfig( new Zend_Config(array('tire'=>array('populateWhenSelectVehicle'=>'true'))));
        $this->assertEquals( 205, $search->sectionWidth(), 'should preselect section width when selecting vehicle');
    }
      
    function testShouldSelectDiameter()
    {
        $vehicle = $this->createTireMMY('Honda','Civic','2000');
        $vehicle->addTireSize( Elite_Vaftire_Model_TireSize::create('205/55-16') );
        
        $search = $this->flexibleTireSearch($vehicle->toValueArray());
	$search->setConfig( new Zend_Config(array('tire'=>array('populateWhenSelectVehicle'=>'true'))));
        $this->assertEquals( 16, $search->diameter(), 'should preselect diameter when selecting vehicle');
    }
      
    function testShouldBeAbleToOverrideSize()
    {
        $vehicle = $this->createTireMMY('Honda','Civic','2000');
        $vehicle->addTireSize( Elite_Vaftire_Model_TireSize::create('205/55-16') );
        
        $params = $vehicle->toValueArray();
        $params['section_width'] = 3;
        
        $search = $this->flexibleTireSearch($params);
        $this->assertEquals( 3, $search->sectionWidth(), 'should be able to override');
    }

    function testShouldNotSelectAspectRatioWhenDisabled()
    {
        $vehicle = $this->createTireMMY('Honda','Civic','2000');
        $vehicle->addTireSize( Elite_Vaftire_Model_TireSize::create('205/55-16') );

        $search = $this->flexibleTireSearch($vehicle->toValueArray());
	$search->setConfig( new Zend_Config(array('tire'=>array('populateWhenSelectVehicle'=>''))));
        $this->assertNull( $search->aspectRatio(), 'should not preselect aspect ratio when selecting vehicle');
    }
}