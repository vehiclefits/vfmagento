<?php
class Elite_Vafsitemap_Model_Url_RewriteTests_ProductListTests_RewriteURLS_StoreCodeInUrlTestTest extends Elite_Vafsitemap_Model_Url_RewriteTests_ProductListTests_RewriteURLS_TestCase
{
    protected $vehicle;
    
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $_SESSION['make'] = null;
        $_SESSION['model'] = null;
        $_SESSION['year'] = null;
        
        $this->definition = $this->createMMY('honda','civic','2000');
    }
    
    function doTearDown()
    {
        $_SERVER['QUERY_STRING'] = ''; 
    }
    
    // when magento rewrites a request, it returns true (and alters the request object in Core_Model_Url_Rewrite line 274)
    
    function testShouldRewriteToProductListing()
    {
        $request = $this->getSEORequest('http://example.com/default/vafsitemap/products/honda~civic~2000/');
        $this->assertTrue( $this->rewrite( $request ), 'should rewrite' );
    }
    
}