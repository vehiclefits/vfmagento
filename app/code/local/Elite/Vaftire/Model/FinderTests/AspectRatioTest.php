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
class Elite_Vaftire_Model_FinderTests_AspectRatioTest extends Elite_TestCase
{
	function testShouldFindAll()
    {
        $this->newTireProduct(1, new Elite_Vaftire_Model_TireSize(null,55,null));
        $this->assertEquals( array(55=>55), $this->tireFinder()->aspectRatios(), 'should find possible aspect ratios' );
    }

    function testShouldSort()
    {
        $this->newTireProduct(1, new Elite_Vaftire_Model_TireSize(null,65,null));
        $this->newTireProduct(2, new Elite_Vaftire_Model_TireSize(null,55,null));
        $this->assertEquals( array(55=>55, 65=>65), $this->tireFinder()->aspectRatios(), 'should sort aspect ratios' );
    }
}