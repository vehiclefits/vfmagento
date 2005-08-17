<?php

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
	$this->assertEquals( $vehicle->toValueArray(), Elite_Vaf_Helper_Data::getInstance()->getFit()->toValueArray(), 'should first select a vehicle');

	$this->setRequestParams(array('section_width' => '205', 'aspect_ratio' => '55', 'diameter' => '16'));
	Elite_Vaf_Helper_Data::getInstance()->flexibleSearch()->doGetProductIds();
	$this->assertFalse(Elite_Vaf_Helper_Data::getInstance()->getFit(), 'should clear vehicle when searching on a tire size');
    }

}