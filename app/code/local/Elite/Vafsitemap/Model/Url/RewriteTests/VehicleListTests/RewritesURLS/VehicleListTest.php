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
class Elite_Vafsitemap_Model_Url_RewriteTests_VehicleListTests_RewritesURLS_VehicleListTest extends Elite_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $_SESSION['make'] = null;
        $_SESSION['model'] = null;
        $_SESSION['year'] = null;
    }
    
    function doTearDown()
    {
        $_SERVER['QUERY_STRING'] = ''; 
    }
    
    function testInvalidVehicle()
    {
        return $this->markTestIncomplete();
        /*
        $rewrite = new Elite_Vafsitemap_Model_Url_RewriteTests_Subclass;
        
        ** @var Zend_Controller_Request_Http *
        $request = $this->request( 'vafsitemap' );
        $request->setPathInfo('vafsitemap/vehicle');
        $_SERVER['QUERY_STRING'] = '?test=2';
        
        $actual = $rewrite->rewrite( $request, new Zend_Controller_Response_Http() );
        $this->assertFalse( $actual, 'when magento doesnt find an id corresponding to a rewrite, this service returns false');
        $this->assertEquals( 'vafsitemap/vehicle', $request->getPathInfo() ); 
        */
    }
}