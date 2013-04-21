<?php

class Elite_Vafgarage_design_frontend_GarageTest extends Elite_Vaf_TestCase
{

    function doSetUp()
    {
	$this->switchSchema('make,model,year');
    }

    function testShouldSelectPartialVehicle()
    {
        $_SESSION['garage'] = new Elite_Vafgarage_Model_Garage;
        $vehicle = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>2000));
        $requestParams = array(
        	'make'=>$vehicle->getLevel('make')->getId(),
        	'model'=>'',
        	'year'=>''
        );
        $this->setRequestParams($requestParams);
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        
        $block = new Elite_Vafgarage_design_garageTestSub;
        $output = $block->_toHtml();
        $this->assertRegExp( '#' . $vehicle->getLevel('make')->getTitle() . '  <#', $output, 'should render only partial vehicle name' );
    }

    

}

class Elite_Vafgarage_design_garageTestSub extends Elite_Vafgarage_Block_Garage
{

    function _toHtml()
    {
	ob_start();
	include('garage.phtml');
	$output = ob_get_clean();
	return $output;
    }

    function getUrl()
    {

    }

    function htmlEscape($string)
    {
	return $string;
    }

}