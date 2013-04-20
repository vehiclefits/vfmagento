<?php
class Elite_Vaf_Model_ObserverTests_MMYTest extends Elite_Vaf_Model_ObserverTests_TestCase
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

        $this->assertTrue($product->fitsVehicle($vehicle), 'should have added the vehicle');
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