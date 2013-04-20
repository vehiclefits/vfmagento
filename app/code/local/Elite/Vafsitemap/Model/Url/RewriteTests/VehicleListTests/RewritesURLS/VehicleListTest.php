<?php
class Elite_Vafsitemap_Model_Url_RewriteTests_VehicleListTests_RewritesURLS_VehicleListTest extends Elite_Vaf_TestCase
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