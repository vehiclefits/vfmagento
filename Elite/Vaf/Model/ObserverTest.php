<?php
class Elite_Vaf_Model_ObserverTest extends Elite_Vaf_TestCase
{

    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }

    function testShouldAddFitment()
    {
        $product = $this->product();
        $vehicle = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>2000));

        // request to add a vehicle based upon it's 'formatted string' (level name [year] and ID).
        $formattedString = 'year-'.$vehicle->getValue('year');
        $request = $this->getRequest();
        $request->setParam('vaf', array($formattedString));

        $this->observer($request);

        $product->setCurrentlySelectedFit($vehicle);
        $this->assertTrue($product->fitsSelection(), 'should have added the vehicle');
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

    function observer($request)
    {
        $event = $this->event($request);
        $observer = new Elite_Vaf_Model_Observer();
        $observer->catalogProductEditAction( $event );
    }

    function event($request)
    {
        $event = new Elite_Vaf_Model_Observer_eventStub();
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