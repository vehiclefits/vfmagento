<?php
class Elite_Vaf_Model_Catalog_ProductTests_FitsSelectionTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{
    function testFits()
    {
        $product = $this->getProduct(1);
        $vehicle = $this->createMMY();
        $this->insertMappingMMY($vehicle,1);
        $this->assertTrue($product->fitsVehicle($vehicle), 'product should fit vehicle');
    }

    function testFitsSelection()
    {
        $product = $this->getProduct(1);
        $vehicle = $this->createMMY();
        $this->insertMappingMMY($vehicle,1);
        $this->setSelectedFit($vehicle);
        $product->setCurrentlySelectedFit($vehicle);
        $this->assertTrue($product->fitsSelection(), 'product should fit selection');
    }

    function testWhenNoSelection()
    {
        $product = $this->getProduct(1);
        $vehicle = $this->createMMY();
        $this->insertMappingMMY($vehicle,1);
        $this->assertFalse($product->fitsSelection(), 'when there is no selection, product should not fit selection');
    }

    function testDoesntFitSelection()
    {
        $product = $this->getProduct(1);
        $vehicle = $this->createMMY('honda','civic','2001');
        $vehicle2 = $this->createMMY('honda','civic','2002');
        $this->insertMappingMMY($vehicle,1);
        $this->setSelectedFit($vehicle2);
        $product->setCurrentlySelectedFit($vehicle2);
        $this->assertFalse($product->fitsSelection(), 'product should not fit selection');
    }

    function setSelectedFit($vehicle)
    {
        Elite_Vaf_Helper_Data::getInstance()->getRequest()->setParams($vehicle->toValueArray());
    }
}
