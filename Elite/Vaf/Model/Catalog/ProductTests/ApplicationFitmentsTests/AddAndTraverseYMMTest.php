<?php
class Elite_Vaf_Model_Catalog_ProductTests_ApplicationFitmentsTests_AddAndTraverseYMMTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('year,make,model');
    }
    
    function testShouldNotCrossover()
    {
        $product = $this->getProduct(1);

        $vehicle1 = $this->createVehicle(array('year'=>2000, 'make'=>'Honda', 'model'=>'Civic'));
        $vehicle2 = $this->createVehicle(array('year'=>2001, 'make'=>'Honda', 'model'=>'Civic'));

        $result = $product->addVafFit( $vehicle1->toValueArray() );
        
        $product->setCurrentlySelectedFit($vehicle1);
        $this->assertTrue( $product->fitsSelection() );
        
        $product->setCurrentlySelectedFit($vehicle2);
        $this->assertFalse( $product->fitsSelection() );
    }
}