<?php
class Elite_Vaf_Model_ObserverTest extends Elite_Vaf_TestCase
{

    function testShouldAddFitment()
    {
        $observer = new Elite_Vaf_Model_Observer();


        $productId = $this->insertProduct('sku');
        $product = new Elite_Vaf_Model_Catalog_Product();
        $product->setId($productId);
        Mage::register( 'current_product', $product );


        $vehicle = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>2000));

        $request = new Zend_Controller_Request_HttpTestCase;
        $request->setParams(array('vaf'=>array(
            'year-'.$vehicle->getValue('year')
        )));

        $event = new Elite_Vaf_Model_Observer_eventStub();
        $event->getControllerAction()->setRequest($request);
        
        $observer->catalogProductEditAction( $event );

        $product->setCurrentlySelectedFit($vehicle);
        $this->assertTrue($product->fitsSelection());
    }
    
    /** @todo get working */
    function testDeleteProductShouldDeleteFits()
    {
        return $this->markTestIncomplete();
        
        $observer = new Elite_Vaf_Model_Observer();
        $product = new Elite_Vaf_Model_Catalog_Product;  
        $this->assertEquals( 'Elite_Vaf_Model_Catalog_Product', get_class($product) );
        $event = new Elite_Vaf_Model_Observer_eventStub();
        $event->object = $product;
        $observer->deleteModelBefore( $event );
    }
    
}

class Elite_Vaf_Model_Observer_eventStub
{
    protected $controller;

    function __construct()
    {
        $this->controller = new Elite_Vaf_Model_Observer_controllerStub;
    }

    function getControllerAction()
    {
        return $this->controller;
    }
}

class Elite_Vaf_Model_Observer_controllerStub
{
    protected $request;

    function getRequest()
    {
        return $this->request;
    }

    function setRequest($request)
    {
        $this->request = $request;
    }
}