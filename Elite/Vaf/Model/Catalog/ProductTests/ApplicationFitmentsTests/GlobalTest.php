<?php
class Elite_Vaf_Model_Catalog_ProductTests_ApplicationFitmentsTests_GlobalTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{
    function doSetUp()
    {
        $schemaGenerator = new Elite_Vaf_Model_Schema_Generator();
        $schemaGenerator->dropExistingTables();
        $schemaGenerator->execute(array(
            'make' => array('global'=>true),
            'model',
            'year' => array('global'=>true)
        ));
        $this->startTransaction();
    }
    
    function doTearDown()
    {
        $schemaGenerator = new Elite_Vaf_Model_Schema_Generator();
        $schemaGenerator->dropExistingTables();
    }
    
    function testTest()
    {
        $vehicle1 = $this->createMMY('Honda', 'Civic', '2000');
        $vehicle2 = $this->createMMY('Ford', 'F-150', '2000');
        
        $product = $this->getProduct(1);
        $product->addVafFit($vehicle1->toValueArray());
        
        $product->setCurrentlySelectedFit($vehicle1);
        $this->assertTrue($product->fitsSelection());
    }
    
    function testTest2()
    {
        $vehicle1 = $this->createMMY('Honda', 'Civic', '2000');
        $vehicle2 = $this->createMMY('Ford', 'F-150', '2000');
        
        $this->assertEquals($vehicle1->getValue('year'), $vehicle2->getValue('year'));
        
        $product = $this->getProduct(1);
        $product->addVafFit($vehicle1->toValueArray());
        
        $product->setCurrentlySelectedFit($vehicle2);
        $this->assertFalse($product->fitsSelection());
    }
}