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

class Elite_Vaftire_Model_FlexibleSearchTests_FilterBySizeTest extends Elite_Vaf_TestCase
{

    function testTireSearch()
    {
	$tireSize = new Elite_Vaftire_Model_TireSize(205, 55, 16);
	$product = $this->newTireProduct(1, $tireSize);

	$flexibleSearch = $this->flexibleTireSearch(array('section_width' => '205', 'aspect_ratio' => '55', 'diameter' => '16'));
	$this->assertEquals(array(1), $flexibleSearch->doGetProductIds(), 'when user is searching on a tire size should find matching tires');
    }

    function testInvalidCombination()
    {
	$tireSize = new Elite_Vaftire_Model_TireSize(205, 55, 16);
	$product = $this->newTireProduct(1, $tireSize);

	$flexibleSearch = $this->flexibleTireSearch(array('section_width' => '206', 'aspect_ratio' => '56', 'diameter' => '17'));
	$this->assertEquals(array(0), $flexibleSearch->doGetProductIds(), 'if user searches on non existant combination there should be no products array(0) is to activate filter');
    }

    function testShouldClearWheelSelection()
    {
	$tireSize = new Elite_Vaftire_Model_TireSize(205, 55, 16);
	$product = $this->newTireProduct(1, $tireSize);

	$tireParamaters = array('section_width' => '205', 'aspect_ratio' => '55', 'diameter' => '16');
	$wheelParamaters = array('lug_count' => '5', 'stud_spread' => '114.3');

	$flexibleWheelSearch = $this->flexibleWheelSearch($wheelParamaters);
	$flexibleWheelSearch->storeSizeInSession();
	$this->assertNotEquals( '', $this->flexibleWheelSearch()->boltPattern()->getLugCount(), 'should first select a wheel size' );

	$flexibleTireSearch = $this->flexibleTireSearch($tireParamaters);
	$flexibleTireSearch->storeTireSizeInSession();

	$this->assertEquals(array(1), Elite_Vaf_Helper_Data::getInstance()->flexibleSearch()->doGetProductIds(), 'should clear wheel search');
	$this->assertEquals('', $this->flexibleWheelSearch()->boltPattern()->getLugCount(), 'should clear bolt pattern from session' );
    }

    function testShouldClearVehicleSelection()
    {
	$vehicle = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>'2000'));
	$this->setRequestParams($vehicle->toValueArray());
	$this->assertEquals( $vehicle->toValueArray(), Elite_Vaf_Helper_Data::getInstance()->vehicleSelection()->toValueArray(), 'should first select a vehicle');

	$this->setRequestParams(array('section_width' => '205', 'aspect_ratio' => '55', 'diameter' => '16'));
	Elite_Vaf_Helper_Data::getInstance()->flexibleSearch()->doGetProductIds();
	$this->assertNull(Elite_Vaf_Helper_Data::getInstance()->vehicleSelection()->getFirstVehicle(), 'should clear vehicle when searching on a tire size');
    }

}