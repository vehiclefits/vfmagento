<?php

class Elite_Vaflogo_Block_LogoTests_YMMTest extends Elite_Vaf_TestCase
{

    function doSetUp()
    {
	$this->switchSchema('year,make,model');
    }

    function testShouldGetSelectionPart()
    {
	$vehicle = $this->createMMY('Honda', 'Civic', '2000');
	$block = new Elite_Vaflogo_Block_Logo;
	$this->setRequestParams($vehicle->toValueArray());
	$this->assertEquals('Honda', $block->selectionPart(), 'should get selection part from selection');
    }

    function testShouldIgnorePartialSelection()
    {
	$vehicle = $this->createMMY('Honda', 'Civic', '2000');
	$block = new Elite_Vaflogo_Block_Logo;

	$params = array('year' => $vehicle->getValue('year'));
	$this->setRequestParams($params);
	$this->assertEquals('', $block->_toHtml(), 'should ignore partial selection');
    }

    function testSelectionTokenShouldBeInUpperCase()
    {
	$vehicle = $this->createMMY('Honda', 'Civic', '2000');
	$block = new Elite_Vaflogo_Block_Logo;
	$this->setRequestParams($vehicle->toValueArray());
	$this->assertEquals('HONDA', $block->selectionToken(), 'selection token should be in UPPER CASE');
    }

    function testShouldDisable()
    {
	return $this->markTestIncomplete();
    }

    function testShouldReturnImageTag()
    {
	$vehicle = $this->createMMY('Honda', 'Civic', '2000');
	$block = new Elite_Vaflogo_Block_Logo;
	$this->setRequestParams($vehicle->toValueArray());
	$this->assertEquals('<img class="vafLogo" src="/logos/HONDA.PNG" />', $block->_toHtml());
    }

}