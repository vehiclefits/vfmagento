<?php

class Elite_Vafsitemap_Model_Url_RewriteTests_VehicleProductPageTests_RewriteURLS_MMYTest extends Elite_Vafsitemap_Model_Url_RewriteTests_TestCase
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

    function testShouldRewriteToVehicleProductPage()
    {
	$vehicle = $this->createMMY('honda', 'civic', '2000');
	$request = $this->getSEORequest('http://example.com/fit/honda~civic~2000/test.html');
	$this->assertTrue($this->rewrite($request), 'should rewrite');
    }

    function testShouldHandleAmperstand()
    {
	$vehicle = $this->createMMY('honda', 'civic&test', '2000');
	$request = $this->getSEORequest('http://example.com/fit/honda~civic%26test~2000/test.html');
	$this->assertTrue($this->rewrite($request), 'should rewrite');
    }

    function testShouldClear()
    {
	$vehicle = $this->createMMY('honda', 'civic', '2000');
	$request = $this->getSEORequest('http://example.com/fit/honda~civic~2000/test.html?make=0&model=0&year=0');
	$this->assertTrue($this->rewrite($request), 'should rewrite');
    }

    function testShouldGetRightPathInfo()
    {
	$vehicle = $this->createMMY('honda', 'civic', '2000');
	$request = $this->getSEORequest('http://example.com/fit/honda~civic~2000/test.html');
	$this->rewrite($request);
	// $this->assertEquals( '/fit/honda-civic-2000/test.html', $request->getRequestUri(), 'this should be the URL the user requested' );
	$this->assertEquals('/catalog/product/view/id/1', $request->getPathInfo(), 'this should be the "internal" pathinfo Magento uses to map to a controller+Action');
    }

    function testShouldStoreVehicle()
    {
	$vehicle = $this->createMMY('honda', 'civic', '2000');
	$request = $this->getSEORequest('http://example.com/fit/honda~civic~2000/test.html');
	$this->setRequest($request);

	$this->rewrite($request);

	Elite_Vaf_Helper_Data::getInstance()->getProductIds();
	$this->assertEquals($vehicle->getLevel('make')->getId(), $_SESSION['make'], 'should look up the right ID#s from the vehicle string');
	$this->assertEquals($vehicle->getLevel('model')->getId(), $_SESSION['model'], 'should look up the right ID#s from the vehicle string');
	$this->assertEquals($vehicle->getLevel('year')->getId(), $_SESSION['year'], 'should look up the right ID#s from the vehicle string');
    }

    function testShouldStorePartialVehicle_ForCustomLevels()
    {
	$vehicle = $this->createMMY('honda', 'civic', '2000');
	$request = $this->getSEORequest('http://example.com/fit/honda~civic/test.html');
	$this->setRequest($request);

	$config = new Zend_Config( array('seo'=>array('rewriteLevels'=>'make,model')) );
	$this->rewrite($request, $config);

	Elite_Vaf_Helper_Data::getInstance()->getProductIds();
	$this->assertEquals($vehicle->getLevel('make')->getId(), $_SESSION['make'], 'should look up the right ID#s from the vehicle string');
	$this->assertEquals($vehicle->getLevel('model')->getId(), $_SESSION['model'], 'should look up the right ID#s from the vehicle string');
	$this->assertEquals(0, $_SESSION['year'], 'should store a partial vehicle for custom levels');
    }

    function rewrite($request, $config=null)
    {
	$rewrite = new Elite_Vafsitemap_Model_Url_RewriteTests_Subclass;
	if(!is_null($config))
	{
	    $rewrite->setConfig($config);
	}
	return $rewrite->rewrite($request, new Zend_Controller_Response_Http());
    }

}