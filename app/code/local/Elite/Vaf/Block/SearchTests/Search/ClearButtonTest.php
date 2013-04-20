<?php
class Elite_Vaf_Block_SearchTests_Search_ClearButtonTest extends Elite_Vaf_Block_SearchTests_TestCase
{
    
    // visibility   
    function testDefaultsToShown()
    {
        $block = $this->getBlock( array( 'search' => array( 'clearButton' => '' ) ) );
        $this->assertTrue( $block->showClearButton(), 'clear button defaults to shown' );
    }
    
    function testShownFalse()
    {
        $block = $this->getBlock( array( 'search' => array( 'clearButton' => 'hide' ) ) );
        $this->assertFalse( $block->showClearButton(), 'setting to false should disable clear button' );
    }
    
    function testLinkShown()
    {
        $block = $this->getBlock( array( 'search' => array( 'clearButton' => 'link' ) ) );
        $this->assertTrue( $block->showClearButton(), 'when in link mode should be shown' );
    }
    
    // modes
    function testDefaultsToButton()
    {
        $block = $this->getBlock( array( 'search' => array( 'clearButton' => '' ) ) );
        $this->assertEquals( 'button', $block->clearButton(), 'clear button defaults to button' );
    }
   
    function testLink()
    {
        $block = $this->getBlock( array( 'search' => array( 'clearButton' => 'link' ) ) );
        $this->assertEquals( 'link', $block->clearButton(), 'should be in link mode' );
    }
    
}