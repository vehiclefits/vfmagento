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
class Elite_Vafwheel_Model_BoltPatternTest extends Elite_Vaf_TestCase
{
    
    function testSingleToString()
    {
        $bolt = Elite_Vafwheel_Model_BoltPattern::create('4x114.3');
        $this->assertEquals( '4x114.3', $bolt->__toString() );
    }
    
    function testSingleLugCount()
    {
        $bolt = Elite_Vafwheel_Model_BoltPattern::create('4x114.3');
        $this->assertEquals( 4, $bolt->getLugCount() );
    }
    
    function testSingleBoltDistance()
    {
        $bolt = Elite_Vafwheel_Model_BoltPattern::create('4x114.3');
        $this->assertEquals( 114.3, $bolt->getDistance() );
    }
    
    function testOffset()
    {
        $bolt = Elite_Vafwheel_Model_BoltPattern::create('4x114.3', 38.5);
        $this->assertEquals( 38.5, $bolt->getOffset() );
    }
    
    function testOffsetThresholdMinimum()
    {
        $bolt = Elite_Vafwheel_Model_BoltPattern::create('4x114.3', 20);
        $this->assertEquals( 15, $bolt->offsetMin() );
    }
    
    function testOffsetThresholdMaximum()
    {
        $bolt = Elite_Vafwheel_Model_BoltPattern::create('4x114.3', 20);
        $this->assertEquals( 25, $bolt->offsetMax() );
    }
}