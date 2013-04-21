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
class Elite_Vafrelated_Model_Catalog_ProductTest extends Elite_Vaf_TestCase
{
    function testCreateNewProduct()
    {
	$product = new Elite_Vaf_Model_Catalog_Product;
	$relatedProduct = new Elite_Vafrelated_Model_Catalog_Product($product);
	$this->assertFalse($relatedProduct->showInRelated(), 'should default to not show in related when create new product');
    }

    function testShouldNotFindUnrelated()
    {
	$vehicle1 = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>2000));
	$vehicle2 = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>2001));

	$product1 = $this->newRelatedProduct(1);

	$product2 = $this->newRelatedProduct(2);
	$product2->addVafFit($vehicle2->toValueArray());

	$this->assertEquals( array(), $product1->relatedProducts($vehicle1), 'should not have related products when vehicle doesn\'t match');
    }

    function testShouldNotFindNotFeatured()
    {
	$vehicle1 = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>2000));
	$vehicle2 = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>2001));

	$product1 = $this->newRelatedProduct(1);

	$product2 = $this->newRelatedProduct(2);
	$product2->addVafFit($vehicle1->toValueArray());
	$product2->setShowInRelated(false);

	$this->assertEquals( array(), $product1->relatedProducts($vehicle1), '');
    }

    function testShouldFindRelatedAndFeautred()
    {
	$vehicle1 = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>2000));
	$vehicle2 = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>2001));

	$product1 = $this->newRelatedProduct(1);

	$product2 = $this->newRelatedProduct(2);
	$product2->addVafFit($vehicle1->toValueArray());
	$product2->setShowInRelated(true);

	$this->assertEquals( array(2), $product1->relatedProducts($vehicle1), '');
    }

    function testShouldExposeRelatedStatus()
    {
	$product = $this->newRelatedProduct(1);
	$product->setShowInRelated(true);
	$this->assertTrue($product->showInRelated());
    }

    function testShouldFitVehicleAndBeRelated()
    {
	$vehicle = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>2000));

	$product = $this->newRelatedProduct(1);
	$product->setCurrentlySelectedFit($vehicle);
	$product->addVafFit($vehicle->toValueArray());
	$product->setShowInRelated(true);

	$this->assertTrue($product->showInRelated());
	$this->assertTrue($product->fitsSelection());
    }

    function newRelatedProduct($id=null)
    {
	$product = $this->newProduct($id);
	return new Elite_Vafrelated_Model_Catalog_Product($product);
    }
}