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