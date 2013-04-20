<?php
require_once 'ProductController.php';
class Elite_Vaf_controllers_ProductControllerTest extends Elite_Vaf_TestCase
{
    const MAKE = 'Honda';
    const MODEL = 'Civic';
    const YEAR = '2002';
    
   function testClearingFitsOnListAction()
   {
       $vehicle = $this->createMMY( self::MAKE, self::MODEL, self::YEAR );
       
       $_SESSION['make'] = $vehicle->getLevel('make')->getId();
       $_SESSION['model'] = $vehicle->getLevel('model')->getId();
       $_SESSION['year'] = $vehicle->getLevel('year')->getId();

       $request = new Zend_Controller_Request_HttpTestCase();
       $request->setParams( array( 'make' => 0, 'model' => 0, 'year' => 0 ) );
       
       $controller = new Elite_Vaf_ProductController_Test( $request, new Zend_Controller_Response_HttpTestCase() );
       $controller->listAction();

       $this->assertFalse( isset( $_SESSION['make']), 'Controller should call storeFitInSession so that the session data gets cleared' );
                          
       
   }    
}
class Elite_Vaf_ProductController_Test extends Elite_Vaf_ProductController
{
    function myLoadLayout()
    {
    }
    
    function redirectToHomePage()
    {
    }  
}