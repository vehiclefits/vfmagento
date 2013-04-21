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
class Elite_Vaflogo_Block_ListYMMTest extends Elite_Vaf_TestCase
{

    function doSetUp()
    {
        $this->switchSchema('year,make,model');
    }

    function testShouldListMakes()
    {
        $vehicle1 = $this->createVehicle(array('make' => 'Honda', 'model' => 'Civic', 'year' => 2000));
        $vehicle2 = $this->createVehicle(array('make' => 'Acura', 'model' => 'Integra', 'year' => 2000));

        $block = new Elite_Vaflogo_Block_List;

        $expected = '<ul><li><a href="?make=' . $vehicle2->getValue('make') . '"><img src="/logos/ACURA.jpg" /></a></li>';
        $expected .= '<li><a href="?make=' . $vehicle1->getValue('make') . '"><img src="/logos/HONDA.jpg" /></a></li></ul>';

        $this->assertEquals($expected, $block->_toHtml());
    }

    function testShouldListDistinctMakesOnly()
    {
        $vehicle1 = $this->createVehicle(array('make' => 'Acura', 'model' => 'Integra', 'year' => 2000));
        $vehicle2 = $this->createVehicle(array('make' => 'Acura', 'model' => 'Integra', 'year' => 2001));
        $this->assertEquals($vehicle1->getValue('make'), $vehicle2->getValue('make'));

        $block = new Elite_Vaflogo_Block_List;

        $expected = '<ul><li><a href="?make=' . $vehicle1->getValue('make') . '"><img src="/logos/ACURA.jpg" /></a></li></ul>';

        $this->assertEquals($expected, $block->_toHtml());
    }
}