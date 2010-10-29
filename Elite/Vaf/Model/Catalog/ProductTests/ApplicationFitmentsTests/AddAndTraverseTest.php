<?php
class Elite_Vaf_Model_Catalog_ProductTests_ApplicationFitmentsTests_AddAndTraverseTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{
    function testAddMultipleMake()
    {
        $product = $this->getProduct(1);

        $vehicle1 = $this->createMMY('Make', 'Model1');
        $vehicle2 = $this->createMMY('Make', 'Model2');

        $result = $product->doAddFit( $vehicle1->getLevel('make') );    
        
        $this->assertEquals( $vehicle1->getValue('model'), $result[0]->getValue('model'), 'should add multiple models for a make' );
        $this->assertEquals( $vehicle2->getValue('model'), $result[1]->getValue('model'), 'should add multiple models for a make' );
    }
    
    function testAddModel()
    {
        $product = $this->getProduct(1);

        $vehicle1 = $this->createMMY('Make', 'Model1');
        $vehicle2 = $this->createMMY('Make', 'Model2');

        $result = $product->doAddFit( $vehicle2->getLevel('model') );    
        
        $this->assertEquals( $vehicle2->getValue('model'), $result[0]->getValue('model'), 'should add model' );
    }

}