<?php
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