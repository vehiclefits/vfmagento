<?php
class Elite_Vaf_Model_ObserverTests_TestCase extends Elite_Vaf_TestCase
{
    function observer($request)
    {
        $event = $this->event($request);
        $observer = new Elite_Vaf_Model_Observer();
        $observer->catalogProductEditAction( $event );
    }

    function event($request)
    {
        $event = new Elite_Vaf_Model_ObserverTests_eventStub();
        $event->getControllerAction()->setRequest($request);
        return $event;
    }

    function product()
    {
        $productId = $this->insertProduct('sku');
        $product = new Elite_Vaf_Model_Catalog_Product();
        $product->setId($productId);
        Mage::register( 'current_product', $product );
        return $product;
    }
    
}
