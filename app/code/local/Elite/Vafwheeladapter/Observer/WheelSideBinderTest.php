<?php
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