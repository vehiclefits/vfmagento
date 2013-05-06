<?php

class Elite_Vafgarage_design_frontend_GarageTest extends VF_TestCase
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
        VF_Singleton::getInstance()->storeFitInSession();
        
        $block = new Elite_Vafgarage_design_garageTestSub;
        $output = $block->_toHtml();

        $this->assertRegExp( '#' . $vehicle->getLevel('make')->getTitle() . '<#', $output, 'should render only partial vehicle name' );
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