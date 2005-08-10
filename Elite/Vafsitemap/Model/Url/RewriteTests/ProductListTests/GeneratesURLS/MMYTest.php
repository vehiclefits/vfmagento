<?php
class Elite_Vafsitemap_Model_Url_RewriteTests_ProductListTests_GeneratesURLS_MMYtest extends Elite_Vafsitemap_Model_Url_RewriteTests_ProductListTests_GeneratesURLS_TestCase
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
    
    function testShouldSeparateLevelsWithTilde()
    {
        $vehicle = $this->createMMY('honda','civic','2000');
        $rewrite = $this->rewrite(1,'test.html',$vehicle);
        $this->assertEquals( 'fit/honda~civic~2000/test.html', $rewrite->getRequestPathRewritten(), 'should separate levels with tilde' );
    }

    function testShouldReplaceSpaceWithDash()
    {
        $vehicle = $this->createMMY('Honda','All Models','2000');
        $rewrite = $this->rewrite(1,'test.html',$vehicle);
        $this->assertEquals( 'fit/Honda~All-Models~2000/test.html', $rewrite->getRequestPathRewritten(), 'should replaces spaces with dashes' );
    }
    
    function testShouldKeepDashesAsIs()
    {
        $vehicle = $this->createMMY('Honda','All-Models','2000');
        $rewrite = $this->rewrite(1,'test.html',$vehicle);
        $this->assertEquals( 'fit/Honda~All-Models~2000/test.html', $rewrite->getRequestPathRewritten(), 'should keep dashes as is' );
    }
    
}