<?php
class Elite_Vafrelated_Model_Catalog_ProductTest extends Elite_Vaf_TestCase
{
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