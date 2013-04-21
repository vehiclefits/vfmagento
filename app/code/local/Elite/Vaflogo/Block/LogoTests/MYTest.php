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