<?php
class Elite_Vaf_Model_ObserverTest extends Elite_Vaf_TestCase
{
	/** @todo get working */
    function test1()
    {
        return $this->markTestIncomplete();
        $observer = new Elite_Vaf_Model_Observer();
        
        $product = new Elite_Vaf_Model_Catalog_Product;
        Mage::register( 'current_product', $product );
        
        $event = new stdClass();
        $observer->catalogProductEditAction( $event );
    }
    
    /** @todo get working */
    function testDeleteProductShouldDeleteFits()
    {
        return $this->markTestIncomplete();
        
        $observer = new Elite_Vaf_Model_Observer();
        $product = new Elite_Vaf_Model_Catalog_Product;  
        $this->assertEquals( 'Elite_Vaf_Model_Catalog_Product', get_class($product) );
        $event = new stdClass();
        $event->object = $product;
        $observer->deleteModelBefore( $event );
    }
    
}