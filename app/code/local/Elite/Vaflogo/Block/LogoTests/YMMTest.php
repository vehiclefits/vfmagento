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

class Elite_Vaflogo_Block_LogoTests_YMMTest extends Elite_TestCase
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