<?php
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