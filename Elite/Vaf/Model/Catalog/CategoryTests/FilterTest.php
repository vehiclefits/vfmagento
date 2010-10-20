<?php
class Elite_Vaf_Model_Catalog_CategoryTests_FilterTest extends Elite_Vaf_Model_Catalog_CategoryTests_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testDoesNotFilterWhenNoVehicleSelected()
    {
        $category = $this->getCategory();
        $category->getProductCollection();
        $this->assertFalse( $category->filtered, 'when there is no vehicle selected, it will not filter' );
    }

    function testDoesFilterWhenVehicleSelected()
    {
        $this->filterOnAMMY();
        $category = $this->getCategory();
        $category->getProductCollection();
        $this->assertTrue( $category->filtered, 'when there is a vehicle selected, it will filter' );
    }
    
    function testWhenFilterIsTrueWillFilter()
    {
        $this->filterOnAMMY();
        $category = $this->categoryFilterWillReturn( true );
        $category->getProductCollection();
        $this->assertTrue( $category->filtered, 'when the filter says to filter, the category WILL filter the products' );
    }
    
    function testWhenFilterIsFalseWillNotFilter()
    {
        $this->filterOnAMMY();
        $category = $this->categoryFilterWillReturn( false );
        $category->getProductCollection();
        $this->assertFalse( $category->filtered, 'when the filter says NOT to filter, the category WILL NOT filter the products' );
    }

}