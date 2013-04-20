<?php
class Elite_Vaf_Model_Catalog_ProductTests_CategoryTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{
    function testInEnabledCategory()
    {
        $product = $this->getMock( 'Elite_Vaf_Model_Catalog_Product', array( 'getCategoryIds' ) );
        $product->expects( $this->any() )->method( 'getCategoryIds' )->will( $this->returnValue( array( 1,2,3 ) ) );
        $product->getCategoryIds();
        $filter = new Elite_Vaf_Model_Catalog_Category_FilterImpl();
        
        $filter->setConfig( new Zend_Config( array( 'category' => array( 'whitelist' => 2 ) ) ) );
        $this->assertTrue( $product->isInEnabledCategory( $filter ) );
    }
    
    function testNotInEnabledCategory()
    {
        $product = $this->getMock( 'Elite_Vaf_Model_Catalog_Product', array( 'getCategoryIds' ) );
        $product->expects( $this->any() )->method( 'getCategoryIds' )->will( $this->returnValue( array( 1,3 ) ) );
        $filter = new Elite_Vaf_Model_Catalog_Category_FilterImpl();
        $filter->setConfig( new Zend_Config( array( 'category' => array( 'whitelist' => 2 ) ) ) );
        $this->assertFalse( $product->isInEnabledCategory( $filter ) );
    }
}
