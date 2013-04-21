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
class Elite_Vafwheeladapter_Observer_WheelSideBinderTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
		$this->switchSchema('make,model,year');
    }
    
    function testIsSilentWhenNoBoltDataPassed()
    {
        $binder = new Elite_Vafwheeladapter_Observer_WheelSideBinder;
        $event = $this->event(new Elite_Vaf_Model_Catalog_Product());
        $binder->bindWheelSide( $event );
    }
    
    function testBindBoltToProduct()
    {
        $this->setRequestParams(array('wheel_side_pattern'=>'4x114.3'));
        
        $binder = new Elite_Vafwheeladapter_Observer_WheelSideBinder;
        $product = new Elite_Vaf_Model_Catalog_Product();
        $product->setId(1);
        $event = $this->event($product);
        $binder->bindWheelSide( $event );
        
        $wheeladapterProduct = new Elite_Vafwheeladapter_Model_Catalog_Product($product);
        $this->assertEquals( 4, $wheeladapterProduct->getWheelSideBoltPattern()->getLugCount(), 'should add bolt pattern to product' );
        $this->assertEquals( 114.3, $wheeladapterProduct->getWheelSideBoltPattern()->getDistance(), 'should add bolt pattern to product' );
    }    
    
    function testUnbindBoltFromProduct()
    {
        $this->setRequestParams(array('wheel_side_pattern'=>'4x114.3'));
        
        $binder = new Elite_Vafwheeladapter_Observer_WheelSideBinder;
        $product = new Elite_Vaf_Model_Catalog_Product();
        $product->setId(1);
        $event = $this->event($product);
        $binder->bindWheelSide( $event );
        
        $this->setRequestParams(array('wheel_side_pattern'=>''));
        
        $binder = new Elite_Vafwheeladapter_Observer_WheelSideBinder;
        $product = new Elite_Vaf_Model_Catalog_Product();
        $product->setId(1);
        $event = $this->event($product);
        $binder->bindWheelSide( $event );
        
        $wheeladapterProduct = new Elite_Vafwheeladapter_Model_Catalog_Product($product);
        $this->assertFalse( $wheeladapterProduct->getWheelSideBoltPattern(), 'should unbind bolt pattern from product' );
    }

    function event($product)
    {
        $event = new stdClass;
        $event->controller = new Elite_Vaf_MockController;
        $event->product = $product;
        return $event;
    }
}