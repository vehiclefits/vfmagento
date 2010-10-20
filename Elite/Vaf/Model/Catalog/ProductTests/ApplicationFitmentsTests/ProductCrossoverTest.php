<?php
class Elite_Vaf_Model_Catalog_ProductTests_ApplicationFitmentsTests_ProductCrossoverTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{
	const PRODUCT_ID = 1;
    const PRODUCT_NAME = 'Widget';
    
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testShouldNotCrossOverProducts()
    {
        $product1 = $this->getProduct(1);
        $product2 = $this->getProduct(2);

        $vehicle1 = $this->createMMY('Make', 'Model1');
        
        $mapping_id = $product1->addVafFit( array('make'=>$vehicle1->getLevel('make')->getId()) );    
        
        $actual = $product1->getFitModels();
        $this->assertEquals( 1, count($actual) );
        
        $actual = $product2->getFitModels();
        $this->assertEquals( 0, count($actual), 'fits should not cross over from one product to another' );
    }
}