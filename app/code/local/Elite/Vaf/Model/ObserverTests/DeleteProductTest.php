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
 * to sales@vehiclefits.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Elite_Vaf_Model_ObserverTests_DeleteProductTest extends Elite_Vaf_Model_ObserverTests_TestCase
{

    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }

    function testShouldDeleteFitmentWhenDeleteProduct()
    {
        $product = $this->product();
        $vehicle = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>2000));
        $product->addVafFit($vehicle->toValueArray());
        $observer = new Elite_Vaf_Model_Observer();

        $event = new stdClass;
        $event->object = $product;
        $observer->deleteModelBefore($event);
        $this->assertEquals(0,count($product->getFits()), 'should have 0 fitments after callback for product deletion');
    }

    function testShouldNotDeleteFitmentsForCategory()
    {
        $category = new Mage_Category_Model;
        $category->setId(1);

        $product = $this->product();
        $product->setId(1);

        $vehicle = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>2000));

        $product->addVafFit($vehicle->toValueArray());
        $observer = new Elite_Vaf_Model_Observer();

        $event = new stdClass;
        $event->object = $category;
        $observer->deleteModelBefore($event);
        $this->assertEquals(1,count($product->getFits()), 'should have 1 fitments after callback for category deletion');
    }

}

class Mage_Category_Model
{
    function setId($id)
    {
        $this->id = $id;
    }

    function getId()
    {
        return $this->id;
    }
}