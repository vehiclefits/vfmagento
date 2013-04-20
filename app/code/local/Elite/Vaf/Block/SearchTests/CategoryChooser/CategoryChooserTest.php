<?php
class Elite_Vaf_Block_SearchTests_CategoryChooser_CategoryChooserTest extends Elite_Vaf_Block_SearchTests_TestCase
{
    /**
    * Tests for wether Search shows When it IS the homempage
    */

    function testWhenNoConfigurationWillNotShowOnHomepage()
    {
        $search = $this->getBlockWithChooserConfig( array() );
        $this->emulateHomepage( $search );
        $this->assertFalse( $search->showCategoryChooser(), 'Default configuration is to not show on homepage' );
    }
    
    function testWhenOnHomepageIsTrueItShowsOnHomepage()
    {
        $search = $this->getBlockWithChooserConfig( array(
            'onHomepage' => true
        ));
        $this->emulateHomepage( $search );
        $this->assertTrue( $search->showCategoryChooser(), 'When it IS the homepage, and onHomepage IS TRUE, it WILL show' );
    }

    function testWhenOnAllPagesIsTrueItShowsOnHomepage()
    {
        $search = $this->getBlockWithChooserConfig( array(
            'onAllPages' => true
        ));
        $this->emulateHomepage( $search );
        $this->assertTrue( $search->showCategoryChooser(), 'When it IS the homepage, and onAllPages = true, it WILL show' );
    }
    
    function testWhenOnHomepageIsFalseItNeverShowsOnHomepage()
    {
        $search = $this->getBlockWithChooserConfig( array(
            'onHomepage' => false,
            'onAllPages' => true                
        ));
        $this->emulateHomepage( $search );
        $this->assertFalse( $search->showCategoryChooser(), 'When it IS the homepage, onHomepage = false, and onAllPages = true, it WILL NOT show' );
    }
  
    
    /**
    * Tests for wether Search shows When it IS NOT the homempage
    */
    
    function testWhenDefaultConfigurationIsUsedItDoesNotShowOnAllPages()
    {
        $search = $this->getBlockWithChooserConfig( array() );
        $this->emulateNotHomepage( $search );
        $this->assertFalse( $search->showCategoryChooser(), 'Default configuration is to not show on all pages' );
    }
    
    function testWhenIsNotHomepageDoesntShow()
    {   
        $search = $this->getBlockWithChooserConfig( array(
            'onHomepage' => true
        ));
        $this->emulateNotHomepage( $search );
        $this->assertFalse( $search->showCategoryChooser(), 'When it IS NOT the homepage, and onHomepage IS TRUE, it WILL NOT show' );
    }
    
    function testWhenOnAllPagesIsTrueItShows()
    {
        $search = $this->getBlockWithChooserConfig( array(
            'onAllPages' => true
        ));
        $this->emulateNotHomepage( $search );
        $this->assertTrue( $search->showCategoryChooser(), 'When onAllPages IS TRUE, it WILL show' );
    }
    

}