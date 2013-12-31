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
 * to sales@vehiclefits.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Elite_Vaf_Block_SearchTests_Search_SubmitButtonTest extends VF_SearchTestCase
{
    
    // visibility   
    function testDefaultsToShown()
    {
        $block = $this->getBlock( array( 'search' => array( 'searchButton' => '' ) ) );
        $this->assertTrue( $block->getSearchStrategy()->showSearchButton(), 'search button defaults to shown' );
    }
    
    function testShownFalse()
    {
        $block = $this->getBlock( array( 'search' => array( 'searchButton' => 'hide' ) ) );
        $this->assertFalse( $block->getSearchStrategy()->showSearchButton(), 'setting to false should disable search button' );
    }
    
    function testLinkShown()
    {
        $block = $this->getBlock( array( 'search' => array( 'searchButton' => 'link' ) ) );
        $this->assertTrue( $block->getSearchStrategy()->showSearchButton(), 'when in link mode should be shown' );
    }
    
    // modes
    function testDefaultsToButton()
    {
        $block = $this->getBlock( array( 'search' => array( 'searchButton' => '' ) ) );
        $this->assertEquals( 'button', $block->getSearchStrategy()->searchButton(), 'search button defaults to button' );
    }
   
    function testLink()
    {
        $block = $this->getBlock( array( 'search' => array( 'searchButton' => 'link' ) ) );
        $this->assertEquals( 'link', $block->getSearchStrategy()->searchButton(), 'should be in link mode' );
    }
    
}