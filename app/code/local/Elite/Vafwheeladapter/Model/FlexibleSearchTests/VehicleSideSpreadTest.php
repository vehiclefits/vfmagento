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
class Elite_Vafwheeladapter_Model_FlexibleSearchTests_VehicleSideSpreadTest extends Elite_TestCase
{
	function testShouldGetFromRequest()
    {
        $flexibleSearch = $this->flexibleWheeladapterSearch(array('vehicle_stud_spread'=>'5'));
        $this->assertEquals( 5, $flexibleSearch->vehicleSideStudSpread(), 'should get vehicle side stud spread from request' );
    }
    
    function testShouldStoreInSession()
    {
        $flexibleSearch = $this->flexibleWheeladapterSearch(array('vehicle_stud_spread'=>'5'));
        Elite_Vaf_Singleton::getInstance()->storeFitInSession();
        $this->assertEquals( 5, $this->flexibleWheeladapterSearch()->vehicleSideStudSpread(), 'should store vehicle side stud spread in session' );
    }
    
    function testShouldClearFromSession()
    {
        $flexibleSearch = $this->flexibleWheeladapterSearch(array('vehicle_stud_spread'=>'5'));
        Elite_Vaf_Singleton::getInstance()->storeFitInSession();
        
        $flexibleSearch = $this->flexibleWheeladapterSearch(array('vehicle_stud_spread'=>'0'));
        Elite_Vaf_Singleton::getInstance()->storeFitInSession();
        
        $this->assertNull( $this->flexibleWheeladapterSearch()->vehicleSideStudSpread(), 'should clear vehicle side stud spread from session' );
    }
}
