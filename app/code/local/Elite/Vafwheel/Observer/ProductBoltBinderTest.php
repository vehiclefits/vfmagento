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
class Elite_Vafwheel_Observer_ProductBoltBinderTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testIsSilentWhenNoBoltDataPassed()
    {
        $binder = new Elite_Vafwheel_Observer_ProductBoltBinder;
        $event = $this->event(new Elite_Vaf_Model_Catalog_Product());
        $binder->addBoltPatterns( $event );
    }
    
    function testAddsBoltPatternToProduct()
    {
        $this->setRequestParams(array('multipatterns'=>'4x114.3'));
        
        $binder = new Elite_Vafwheel_Observer_ProductBoltBinder;
        $product = new Elite_Vaf_Model_Catalog_Product();
        $product->setId(1);
        $event = $this->event($product);
        $binder->addBoltPatterns( $event );
        
        $wheelProduct = new Elite_Vafwheel_Model_Catalog_Product($product);
        $this->assertEquals( 1, count($wheelProduct->getBoltPatterns()), 'should add bolt pattern to product' );
    } 
    
    function testAddsMultipleBoltPatternsToProduct()
    {
        $this->setRequestParams(array('multipatterns'=>"4x114.3\n5x114.3"));
        
        $binder = new Elite_Vafwheel_Observer_ProductBoltBinder;
        $product = new Elite_Vaf_Model_Catalog_Product();
        $product->setId(1);
        $event = $this->event($product);
        $binder->addBoltPatterns( $event );
        
        $wheelProduct = new Elite_Vafwheel_Model_Catalog_Product($product);
        $this->assertEquals( 2, count($wheelProduct->getBoltPatterns()), 'should add multiple bolt patterns to product' );
    }
    
    function testAddsAndRemovesBoltPattern()
    {
        $this->setRequestParams(array('multipatterns'=>"4x114.3\n5x114.3"));
        
        $binder = new Elite_Vafwheel_Observer_ProductBoltBinder;
        $product = new Elite_Vaf_Model_Catalog_Product();
        $product->setId(1);
        $event = $this->event($product);
        $binder->addBoltPatterns( $event );
        
        $wheelProduct = new Elite_Vafwheel_Model_Catalog_Product($product);
        $this->assertEquals( 2, count($wheelProduct->getBoltPatterns()) );
        
        $this->setRequestParams(array('wheel_side_pattern'=>"4x114.3"));
        
        $binder = new Elite_Vafwheel_Observer_ProductBoltBinder;
        $product = new Elite_Vaf_Model_Catalog_Product();
        $product->setId(1);
        $event = $this->event($product);
        $binder->addBoltPatterns( $event );
        
        $wheelProduct = new Elite_Vafwheel_Model_Catalog_Product($product);
        $this->assertEquals( 1, count($wheelProduct->getBoltPatterns()), 'removes previously added bolt patterns' );
    }
    
    function event($product)
    {
        $event = new stdClass;
        $event->controller = new Elite_Vaf_MockController;
        $event->product = $product;
        return $event;
    }
}