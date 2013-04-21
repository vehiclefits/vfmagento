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
class Elite_Vafsitemap_Model_Url_RewriteTests_ProductListTests_RewriteURLS_URLTemplateTest extends Elite_Vafsitemap_Model_Url_RewriteTests_ProductListTests_RewriteURLS_TestCase
{
    protected $vehicle;

    function doSetUp()
    {
        $this->switchSchema('make,model,year,engine');
        $_SESSION['make'] = null;
        $_SESSION['model'] = null;
        $_SESSION['year'] = null;
        $_SESSION['engine'] = null;

        $this->definition = $this->createVehicle(array('make' => 'honda', 'model' => 'civic', 'year' => '2000', 'engine' => '1.0'));
    }

    function doTearDown()
    {
        $_SERVER['QUERY_STRING'] = '';
    }

    // when magento rewrites a request, it returns true (and alters the request object in Core_Model_Url_Rewrite line 274)

    function testShouldRewriteToProductListing()
    {
        $request = $this->getSEORequest('http://example.com/vafsitemap/products/honda~civic~2000/');
        $config = new Zend_Config(array('seo' => array('rewriteLevels' => 'make,model,year')));
        $this->assertTrue($this->rewrite($request, $config), 'should rewrite');
    }

    function testShouldGetVehicleIdAndStoreInSession()
    {
        $request = $this->getSEORequest('http://example.com/vafsitemap/products/honda~civic~2000/');
        $config = new Zend_Config(array('seo' => array('rewriteLevels' => 'make,model,year')));
        $this->rewrite($request, $config);
        $this->setRequest($request);

        Elite_Vaf_Helper_Data::getInstance()->getProductIds();
        $this->assertEquals($this->definition->getLevel('make')->getId(), $_SESSION['make'], 'should look up the right ID#s from the vehicle string, and store in session');
        $this->assertEquals($this->definition->getLevel('model')->getId(), $_SESSION['model'], 'should look up the right ID#s from the vehicle string, and store in session');
        $this->assertEquals($this->definition->getLevel('year')->getId(), $_SESSION['year'], 'should look up the right ID#s from the vehicle string, and store in session');
        $this->assertEquals(0, $_SESSION['engine'], 'should have partial vehicle selection');
    }
}