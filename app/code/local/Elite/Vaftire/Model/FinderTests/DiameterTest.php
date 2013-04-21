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
class Elite_Vaftire_Model_FinderTests_DiameterTest extends Elite_Vaf_TestCase
{
    function testShouldFindAll()
    {
        $this->newTireProduct(1, new Elite_Vaftire_Model_TireSize(null,null,16));
        $this->assertEquals( array(16=>16), $this->tireFinder()->diameters(), 'should find possible diameter' );
    }

    function testShouldSort()
    {
        $this->newTireProduct(1, new Elite_Vaftire_Model_TireSize(null,null,18));
        $this->newTireProduct(2, new Elite_Vaftire_Model_TireSize(null,null,15));
        $this->assertEquals( array(15=>15, 18=>18), $this->tireFinder()->diameters(), 'should sort diameter' );
    }
}