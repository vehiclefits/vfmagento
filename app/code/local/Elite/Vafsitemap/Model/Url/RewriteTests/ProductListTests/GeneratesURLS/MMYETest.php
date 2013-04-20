<?php
class Elite_Vafsitemap_Model_Url_RewriteTests_ProductListTests_GeneratesURLS_MMYEtest extends Elite_Vafsitemap_Model_Url_RewriteTests_ProductListTests_GeneratesURLS_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year,engine');
        $_SESSION['make'] = null;
        $_SESSION['model'] = null;
        $_SESSION['year'] = null;
        $_SESSION['engine'] = null;
    }
    
    function doTearDown()
    {
        $_SERVER['QUERY_STRING'] = ''; 
    }
    
    // when magento rewrites a request, it returns true (and alters the request object in Core_Model_Url_Rewrite line 274)
    
    function testShouldSeparateLevelsWithTilde()
    {
        $vehicle = $this->createVehicle(array('make'=>'honda', 'model'=>'civic', 'year'=>'2000', 'engine'=>'1.0'));
        $rewrite = $this->rewrite(1,'test.html',$vehicle);
        $this->assertEquals( 'fit/honda~civic~2000~1.0/test.html', $rewrite->getRequestPathRewritten(), 'should separate levels with tilde' );
    }
    
    function testShouldUseRewriteTemplate()
    {
        $config = new Zend_Config( array('seo'=>array('rewriteLevels'=>'make,model,year')) );
        $vehicle = $this->createVehicle(array('make'=>'honda', 'model'=>'civic', 'year'=>'2000', 'engine'=>'1.0'));
        $rewrite = $this->rewrite(1,'test.html',$vehicle);
        $rewrite->setConfig($config);
        $this->assertEquals( 'fit/honda~civic~2000/test.html', $rewrite->getRequestPathRewritten(), 'should use rewrite template' );
    }
    
}