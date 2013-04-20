<?php
class Elite_Vaf_Block_Search_ChoosevehicleTest extends Elite_Vaf_Block_SearchTests_TestCase
{
    function testDoesntShowCategoryChooser()
    {
        $block = new Elite_Vaf_Block_Search_Choosevehicle;
        $block->setConfig( new Zend_Config( array(
            'categorychooser' => array(
                'onHomepage' => true,
                'onAllPages' => true
            )
        )) );
        $this->assertFalse( $block->showCategoryChooser() );
    }
    
    function testShowsSubmitButton()
    {
        $block = new Elite_Vaf_Block_Search_Choosevehicle;
        $block->setConfig( new Zend_Config( array(
            'search' => array(
                'searchButton ' => false
            )
        )) );
        $this->assertTrue( $block->showSubmitButton() );
    }
    
    function testWillNotShowClearButton()
    {
        $block = new Elite_Vaf_Block_Search_Choosevehicle;
        $this->assertFalse( $block->showClearButton() );
    }
    
    function testAction()
    {
        $block = new Elite_Vaf_Block_Search_Choosevehicle;
        $this->assertEquals( '?', $block->action() );
    }
    
    function testShouldBeNoModelsPreselected_WhenNoVehicleIsSelected()
    {
        $vehicle = $this->createMMYWithFitment();
        $block = new Elite_Vaf_Block_Search_Choosevehicle;
        $actual = $block->listEntities('model');
        $this->assertEquals( array(), $actual, 'should be no models pre-selected when vehicle not selected' );
    }
}
