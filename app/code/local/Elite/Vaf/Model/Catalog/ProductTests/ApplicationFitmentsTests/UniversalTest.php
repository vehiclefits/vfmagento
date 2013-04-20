<?php
class Elite_Vaf_Model_Catalog_ProductTests_ApplicationFitmentsTests_UniversalTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{
	const PRODUCT_ID = 1;
    const PRODUCT_NAME = 'Widget';
    
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testGetFitsUniversal()
    {
        $product = $this->getProduct(self::PRODUCT_ID);
        $this->assertFalse( $product->isUniversal() );  
        $this->insertUniversalFit( $product->getId() );
        
        $product = $this->getProduct(self::PRODUCT_ID);
        $this->assertTrue( $product->isUniversal() );
    }
}