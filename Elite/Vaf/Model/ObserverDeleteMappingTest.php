<?php
class Elite_Vaf_Model_ObserverDeleteMappingTest extends Elite_Vaf_TestCase
{
    const PRODUCT_ID = 1;

    function testDeletingFits()
    {
        // create product & a fit
        $vehicle = $this->createMMY();
        $fit_id = $this->insertMappingMMY( $vehicle, self::PRODUCT_ID );
        
        $product = $this->getProduct( self::PRODUCT_ID );
        
        $request = $this->getRequest( array(
            'vaf-delete' => array( 'year-' . $fit_id )
        ));
            
        // mock up an event and pass it to the SUT observer
        $event = $this->getMock( 'myEvent' );
        $event->expects( $this->any() )->method( 'getControllerAction' )->will( $this->returnValue( $this->getController( $request ) ) );
        Mage::register( 'current_product', $product );
            
        $observer = new Elite_Vaf_Model_Observer_Test();
        $observer->catalogProductEditAction( $event );
        
        $request = $this->getRequest(array(
            'make' => $vehicle->getLevel('make')->getId(),
            'model' => $vehicle->getLevel('model')->getId(),
            'year' => $vehicle->getLevel('year')->getId()
        ));
        $helper = new Elite_Vaf_Helper_Data;
        $helper->setRequest( $request );
        $this->assertEquals( array(0), $helper->getProductIds(), 'deleting fitments should result in there being no fitments' );
    }
    
    protected function getProduct( $Id )
    {
        $product = new Elite_Vaf_Model_Catalog_Product();
        $product->setId( $Id );
        return $product;
    }
    
    protected function getController( $request )
    {
        $controller = $this->getMock( 'Zend_Controller_Action', array(), array(), '', false);
        $controller->expects( $this->any() )->method( 'getRequest' )->will( $this->returnValue( $request ) );
        return $controller;
    }
 
}

class Elite_Vaf_Model_Observer_Test extends Elite_Vaf_Model_Observer
{
    protected function dispatchProductEditEvent( $controller, $product )
    {
        
    }
}

class myEvent extends Varien_Event_Observer
{
    function getControllerAction() {}
}