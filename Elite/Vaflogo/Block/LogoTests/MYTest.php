<?php
class Elite_Vaflogo_Block_LogoTests_MYTest extends Elite_Vaf_TestCase
{

    function doSetUp()
    {
	$this->switchSchema('model,year');
    }

    function testShouldReturnImageTag()
    {
	$vehicle = $this->createVehicle(array('model'=>'Civic', 'year'=>2000));
	
	$block = new Elite_Vaflogo_Block_Logo;
	$block->setConfig( new Zend_Config( array('logo' => array()) ) );

	$this->setRequestParams($vehicle->toValueArray());
	$this->assertEquals('<img class="vafLogo" src="/logos/CIVIC.PNG" />', $block->_toHtml());
    }

    function testShouldUseJPG()
    {
	$vehicle = $this->createVehicle(array('model'=>'Civic', 'year'=>2000));

	$block = new Elite_Vaflogo_Block_Logo;
	$block->setConfig( new Zend_Config( array('logo' => array('extension'=>'jpg')) ) );

	$this->setRequestParams($vehicle->toValueArray());
	$this->assertEquals('<img class="vafLogo" src="/logos/CIVIC.jpg" />', $block->_toHtml());
    }

    function testShouldOverrideLevel()
    {
	$vehicle = $this->createVehicle(array('model'=>'Civic', 'year'=>2000));

	$block = new Elite_Vaflogo_Block_Logo;
	$block->setConfig( new Zend_Config( array('logo' => array('level'=>'year')) ) );

	$this->setRequestParams($vehicle->toValueArray());
	$this->assertEquals('<img class="vafLogo" src="/logos/2000.PNG" />', $block->_toHtml());
    }
}