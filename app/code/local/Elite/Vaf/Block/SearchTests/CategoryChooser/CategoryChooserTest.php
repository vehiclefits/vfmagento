<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
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