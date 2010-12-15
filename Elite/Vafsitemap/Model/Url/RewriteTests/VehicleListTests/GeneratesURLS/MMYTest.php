<?php
class Elite_Vafsitemap_Model_Url_RewriteTests_VehicleListTests_GeneratesURLS_MMYTest extends Elite_Vaf_TestCase
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
    
    function testShouldSeparateLevelsWithTilde()
    {
        $vehicle = $this->createMMY('honda','civic','2000');
        $rewrite = $this->rewrite();
        $this->assertEquals( 'vafsitemap/products/honda~civic~2000/', $rewrite->getProductListingUrl($vehicle), 'should separate levels with tilde' );
    }
    
    function testShouldReplaceSpaceWithDash()
    {
        $vehicle = $this->createMMY('Honda','All Models','2000');
        $rewrite = $this->rewrite();
        $this->assertEquals( 'vafsitemap/products/Honda~All-Models~2000/', $rewrite->getProductListingUrl($vehicle), 'should replaces spaces with dashes' );
    }
    
    function testShouldKeepDashesAsIs()
    {
        $vehicle = $this->createMMY('Honda','All-Models','2000');
        $rewrite = $this->rewrite();
        $this->assertEquals( 'vafsitemap/products/Honda~All-Models~2000/', $rewrite->getProductListingUrl($vehicle), 'should keep dashes as is' );
    }
    
    function rewrite( Zend_Controller_Request_Http $request = null )
    {
		return new Elite_Vafsitemap_Model_Url_RewriteTests_Subclass;
    }

}