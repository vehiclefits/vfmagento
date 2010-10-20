<?php
class Elite_Vafsitemap_Model_Url_RewriteTests_VehicleProductPageTests_RewriteURLS_MMYDashesTest extends Elite_Vafsitemap_Model_Url_RewriteTests_TestCase
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
    
    function testShouldReplaceDashWithSpace()
    {
        $vehicle = $this->createMMY('honda','All Models','2000');
        $request = $this->getSEORequest('http://example.com/default/fit/Honda~All-Models~2000/test.html');
        $this->assertTrue( $this->rewrite($request), 'should rewrite' );
	}
	
    function testShouldUseActualDash()
    {
        $vehicle = $this->createMMY('honda','All-Models','2000');
        $request = $this->getSEORequest('http://example.com/default/fit/Honda~All-Models~2000/test.html');
        $this->assertTrue( $this->rewrite($request), 'should rewrite' );
	}
    
    function testShouldUseMixedDash()
    {
        return $this->markTestIncomplete();
        $vehicle = $this->createMMY('All Makes','All-Models','2000');
        $request = $this->getSEORequest('http://example.com/default/fit/All-Makes~All-Models~2000/test.html');
        $this->assertTrue( $this->rewrite($request), 'should rewrite' );
	}
    
    function rewrite($request)
    {
		$rewrite = new Elite_Vafsitemap_Model_Url_RewriteTests_Subclass;
		return $rewrite->rewrite($request, new Zend_Controller_Response_Http());
    }
}