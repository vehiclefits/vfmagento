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
class Elite_Vaftire_Model_TireSizeTests_ConstructorTest extends Elite_TestCase
{
    function testSectionWidth()
    {
        $tireSize = new Elite_Vaftire_Model_TireSize(205,null,null);
        $this->assertEquals(205,$tireSize->sectionWidth(),'tire size has a section width');
    }
    
    function testAspectRatio()
    {
        $tireSize = new Elite_Vaftire_Model_TireSize(null,55,null);
        $this->assertEquals(55,$tireSize->aspectRatio(),'tire size has an aspect ratio');
    }
    
    function testDiameter()
    {
        $tireSize = new Elite_Vaftire_Model_TireSize(null,null,16);
        $this->assertEquals(16,$tireSize->diameter(),'tire size has a diameter');
    }
    
    function testShouldFormatString()
    {
        $tireSize = new Elite_Vaftire_Model_TireSize(205,55,16);
        $this->assertEquals( '205/55-16', (string)$tireSize, 'should format a tire size string' );
    }
    
}