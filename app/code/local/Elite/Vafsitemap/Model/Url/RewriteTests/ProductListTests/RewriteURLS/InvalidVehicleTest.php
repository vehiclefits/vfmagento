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
class Elite_Vafsitemap_Model_Url_RewriteTests_ProductListTests_RewriteURLS_InvalidVehicleTest extends Elite_Vafsitemap_Model_Url_RewriteTests_ProductListTests_RewriteURLS_TestCase
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
    
    // when magento rewrites a request, it returns true (and alters the request object in Core_Model_Url_Rewrite line 274)
    
    function testRequestUri()
    {
        $request = $this->getSEORequest('http://example.com/vafsitemap/products/404~404~404/');
        $this->assertEquals( '/vafsitemap/products/404~404~404/', $request->getRequestUri(), 'this should be the URL the user requested' );
    }
    
    function testShouldNotRewrite()
    {
        $request = $this->getSEORequest('http://example.com/vafsitemap/products/404~404~404/');
        $this->assertFalse( $this->rewrite($request), 'should not rewrite' );
    }
}