<?php
class Elite_Vaf_Block_SearchTests_Search_SubmitButtonTest extends Elite_Vaf_Block_SearchTests_TestCase
{
    
    // visibility   
    function testDefaultsToShown()
    {
        $block = $this->getBlock( array( 'search' => array( 'searchButton' => '' ) ) );
        $this->assertTrue( $block->showSearchButton(), 'search button defaults to shown' );
    }
    
    function testShownFalse()
    {
        $block = $this->getBlock( array( 'search' => array( 'searchButton' => 'hide' ) ) );
        $this->assertFalse( $block->showSearchButton(), 'setting to false should disable search button' );
    }
    
    function testLinkShown()
    {
        $block = $this->getBlock( array( 'search' => array( 'searchButton' => 'link' ) ) );
        $this->assertTrue( $block->showSearchButton(), 'when in link mode should be shown' );
    }
    
    // modes
    function testDefaultsToButton()
    {
        $block = $this->getBlock( array( 'search' => array( 'searchButton' => '' ) ) );
        $this->assertEquals( 'button', $block->searchButton(), 'search button defaults to button' );
    }
   
    function testLink()
    {
        $block = $this->getBlock( array( 'search' => array( 'searchButton' => 'link' ) ) );
        $this->assertEquals( 'link', $block->searchButton(), 'should be in link mode' );
    }
    
}