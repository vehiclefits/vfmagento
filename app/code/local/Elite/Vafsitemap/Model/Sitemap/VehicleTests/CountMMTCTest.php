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
class Elite_Vafsitemap_Model_Sitemap_VehicleTests_CountMMTCTest extends Elite_TestCase
{
    protected $make, $model, $trim, $chassis;
    
    function doSetUp()
    {
        $this->switchSchema( 'make,model,trim,chassis' );
    }
    
    function testCount0()
    {
        $sitemap = new Elite_Vafsitemap_Model_Sitemap_Vehicle(Elite_Vaf_Singleton::getInstance()->getConfig());
        $this->assertEquals( 0, $sitemap->vehicleCount() );
    }

    function testCount1()
    {
        $sitemap = new Elite_Vafsitemap_Model_Sitemap_Vehicle(Elite_Vaf_Singleton::getInstance()->getConfig());
        $vehicle = $this->createMMTC();
        $this->insertMappingMMTC( $vehicle );
        $this->assertEquals( 1, $sitemap->vehicleCount() );
    }

}