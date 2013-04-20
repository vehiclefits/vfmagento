<?php
class Elite_Vaf_Model_Catalog_ProductTests_UniversalTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{
    function testIsUniversal()
    {
        $product = new Elite_Vaf_Model_Catalog_Product();
        $product->setId( 1 );
        $product->setUniversal( true );
        $this->assertTrue( $product->isUniversal() );
    }
    
    function testIsNotUniversal()
    {
        $product = new Elite_Vaf_Model_Catalog_Product();
        $product->setId( 1 );
        $product->setUniversal( false );
        $this->assertFalse( $product->isUniversal() );
    }
}
