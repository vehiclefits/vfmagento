<?php
class Elite_Vaf_Block_SearchTests_CategoryChooser_IgnoreCategoryTest extends Elite_Vaf_Block_SearchTests_TestCase
{
    
    function testWhenCategoriesBlacklistedItFilters()
    {
        $search = $this->getBlockWithChooserConfig( array(
            'ignore' => 1
        ));
        $categories = $search->getFilteredCategories( array(
            array( 'id' => 1, 'url' => 'foo', 'title' => 'bar' ),
            array( 'id' => 2, 'url' => 'foo', 'title' => 'bar' )
        ));
        $count = count( $categories );
        $this->assertTrue( 1 == $count && $categories[0]['id'] == 2, 'filters out the category id 1 when user set the ignore paramater to 1' );
    }
    
    function testWhenMultipleCategoriesBlacklistedItFilters()
    {
        $search = $this->getBlockWithChooserConfig( array(
            'ignore' => '1, 2'
        ));
        $categories = $search->getFilteredCategories( array(
            array( 'id' => 1, 'url' => 'foo', 'title' => 'bar' ),
            array( 'id' => 2, 'url' => 'foo', 'title' => 'bar' )
        ));
        $this->assertTrue( 0 == count( $categories ), 'filters out the category id 1 & 2 when user set the ignore paramater to 1, 2' );
    }
    
    function testWhenNoConfigurationItDoesntFilter()
    {
        $search = $this->getBlockWithChooserConfig( array() );
        $categories = $search->getFilteredCategories( array(
            array( 'id' => 1, 'url' => 'foo', 'title' => 'bar' ),
            array( 'id' => 2, 'url' => 'foo', 'title' => 'bar' )
        ));
        $count = count( $categories );
        $this->assertTrue( 2 == $count && $categories[0]['id'] == 1 && $categories[1]['id'] == 2, 'does not filter category when user did not set ignore paramater' );
    }
    
}