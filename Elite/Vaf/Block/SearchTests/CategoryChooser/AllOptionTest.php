<?php
class Elite_Vaf_Block_SearchTests_CategoryChooser_AllOptionTest extends Elite_Vaf_Block_SearchTests_TestCase
{
    /**
    * Tests for wether All Option shows when it IS the homepage
    */
    function testWhenNoConfigurationWillNotShowOnHomepage()
    {
        $search = $this->getBlockWithChooserConfig( array() );
        $this->emulateHomepage( $search );
        $this->assertFalse( $search->showAllOptionOnCategoryChooser(), 'When no configuration, it WILL NOT show' );
    }
    
    function testWhenallOptionOnHomepageIsTrueItShowsOnHomepage()
    {
        $search = $this->getBlockWithChooserConfig( array(
            'allOptionOnHomepage' => true
        ));
        $this->emulateHomepage( $search );
        $this->assertTrue( $search->showAllOptionOnCategoryChooser(), 'When it IS the homepage, and allOptionOnHomepage IS TRUE, it WILL show' );
    }
    
    function testWhenallOptionOnAllPagesIsTrueItShowsOnHomepage()
    {
        $search = $this->getBlockWithChooserConfig( array(
            'allOptionOnAllPages' => true
        ));
        $this->emulateHomepage( $search );
        $this->assertTrue( $search->showAllOptionOnCategoryChooser(), 'When it IS the homepage, and allOptionOnAllPages = true, it WILL show' );
    }
    
    function testWhenOnHomepageIsFalseItNeverShowsOnHomepage()
    {
        $search = $this->getBlockWithChooserConfig( array(
            'allOptionOnHomepage' => false,
            'allOptionOnAllPages' => true                
        ));
        $this->emulateHomepage( $search );
        $this->assertFalse( $search->showAllOptionOnCategoryChooser(), 'When it IS the homepage, allOptionOnHomepage = false, and allOptionOnAllPages = true, it WILL NOT show' );
    }
    
    
    /**
    * Tests for wether All Option shows when it IS NOT the homepage
    */
    
    function testWhenDefaultConfigurationIsUsedItDoesNotShowOnAllPages()
    {
        $search = $this->getBlockWithChooserConfig( array() );
        $this->emulateNotHomepage( $search );
        $this->assertFalse( $search->showAllOptionOnCategoryChooser(), 'Default configuration is to not show on all pages' );
    }
    
    function testWhenIsNotHomepageDoesntShow()
    {   
        $search = $this->getBlockWithChooserConfig( array(
            'allOptionOnHomepage' => true
        ));
        $this->emulateNotHomepage( $search );
        $this->assertFalse( $search->showAllOptionOnCategoryChooser(), 'When it IS NOT the homepage, and onHomepage IS TRUE, it WILL NOT show' );
    }
    
    function testWhenOnAllPagesIsTrueItShows()
    {
        $search = $this->getBlockWithChooserConfig( array(
            'allOptionOnAllPages' => true
        ));
        $this->emulateNotHomepage( $search );
        $this->assertTrue( $search->showAllOptionOnCategoryChooser(), 'When onAllPages IS TRUE, it WILL show' );
    }
    
}