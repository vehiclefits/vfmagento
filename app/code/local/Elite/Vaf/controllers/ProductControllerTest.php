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