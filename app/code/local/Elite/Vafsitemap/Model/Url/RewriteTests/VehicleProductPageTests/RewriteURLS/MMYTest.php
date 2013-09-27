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
        return $this->markTestIncomplete();
	$vehicle = $this->createMMY('honda', 'civic', '2000');
	$request = $this->getSEORequest('http://example.com/fit/honda~civic~2000/test.html');
	$this->assertTrue($this->rewrite($request), 'should rewrite');
    }

    function testShouldHandleAmperstand()
    {
        return $this->markTestIncomplete();
	$vehicle = $this->createMMY('honda', 'civic&test', '2000');
	$request = $this->getSEORequest('http://example.com/fit/honda~civic%26test~2000/test.html');
	$this->assertTrue($this->rewrite($request), 'should rewrite');
    }

    function testShouldClear()
    {
        return $this->markTestIncomplete();
	$vehicle = $this->createMMY('honda', 'civic', '2000');
	$request = $this->getSEORequest('http://example.com/fit/honda~civic~2000/test.html?make=0&model=0&year=0');
	$this->assertTrue($this->rewrite($request), 'should rewrite');
    }

    function testShouldGetRightPathInfo()
    {
        return $this->markTestIncomplete();
	$vehicle = $this->createMMY('honda', 'civic', '2000');
	$request = $this->getSEORequest('http://example.com/fit/honda~civic~2000/test.html');
	$this->rewrite($request);
	// $this->assertEquals( '/fit/honda-civic-2000/test.html', $request->getRequestUri(), 'this should be the URL the user requested' );
	$this->assertEquals('/catalog/product/view/id/1', $request->getPathInfo(), 'this should be the "internal" pathinfo Magento uses to map to a controller+Action');
    }

    function testShouldStoreVehicle()
    {
        return $this->markTestIncomplete();
	$vehicle = $this->createMMY('honda', 'civic', '2000');
	$request = $this->getSEORequest('http://example.com/fit/honda~civic~2000/test.html');
	$this->setRequest($request);

	$this->rewrite($request);

	Elite_Vaf_Singleton::getInstance()->getProductIds();
	$this->assertEquals($vehicle->getLevel('make')->getId(), $_SESSION['make'], 'should look up the right ID#s from the vehicle string');
	$this->assertEquals($vehicle->getLevel('model')->getId(), $_SESSION['model'], 'should look up the right ID#s from the vehicle string');
	$this->assertEquals($vehicle->getLevel('year')->getId(), $_SESSION['year'], 'should look up the right ID#s from the vehicle string');
    }

    function testShouldStorePartialVehicle_ForCustomLevels()
    {
        return $this->markTestIncomplete();
	$vehicle = $this->createMMY('honda', 'civic', '2000');
	$request = $this->getSEORequest('http://example.com/fit/honda~civic/test.html');
	$this->setRequest($request);

	$config = new Zend_Config( array('seo'=>array('rewriteLevels'=>'make,model')) );
	$this->rewrite($request, $config);

	Elite_Vaf_Singleton::getInstance()->getProductIds();
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