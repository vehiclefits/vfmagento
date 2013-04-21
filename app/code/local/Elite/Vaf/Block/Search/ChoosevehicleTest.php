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
