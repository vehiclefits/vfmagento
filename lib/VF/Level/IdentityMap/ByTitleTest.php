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
class VF_Level_IdentityMap_ByTitleTest extends Elite_Vaf_TestCase
{
    function testPrefixingZero()
    {
        $identityMap = new VF_Level_IdentityMap_ByTitle();
        $identityMap->add(1,'make','01');
        $this->assertFalse( $identityMap->has('make','1'));
    }
    
    function testPrefixingZero2()
    {
        $identityMap = new VF_Level_IdentityMap_ByTitle();
        $identityMap->add(1,'make','01');
        $this->assertFalse( $identityMap->get('make','1'));
    }
}