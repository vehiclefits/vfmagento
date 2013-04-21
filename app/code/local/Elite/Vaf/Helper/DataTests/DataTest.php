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
class Elite_Vaf_Helper_DataTest_DataTest extends Elite_Vaf_Helper_DataTestCase
{
    function testGetDefaultSearchOptionText()
    {
        $helper = $this->getHelper( array( 'search' => array( 'defaultText' => 'foo' ) ) );
        $this->assertEquals( 'foo', $helper->getDefaultSearchOptionText() );
    }
    
    function testGetDefaultSearchOptionTextPerLevel()
    {
        $helper = $this->getHelper( array( 'search' => array( 'defaultText' => '- Pick %s -' ) ) );
        $this->assertEquals( '- Pick Make -', $helper->getDefaultSearchOptionText('make') );
    }
    
    function testGetDefaultSearchOptionTextDefault()
    {
        $helper = $this->getHelper( array( 'search' => array() ) );
        $this->assertEquals( '-please select-', $helper->getDefaultSearchOptionText() );
    }
    
    function testLabelsDefaultsTrue()
    {
        $helper = $this->getHelper( array( 'search' => array() ) );
        $this->assertTrue( $helper->showLabels() );
    }
    
    function testLabelsShouldDisable()
    {
        $helper = $this->getHelper( array( 'search' => array('labels'=>false) ) );
        $this->assertFalse( $helper->showLabels() );
    }
    
    function testLabelsShouldEndable()
    {
        $helper = $this->getHelper( array( 'search' => array('labels'=>true) ) );
        $this->assertTrue( $helper->showLabels() );
    }
    
    function testDefaultBrTag()
    {
        $helper = $this->getHelper( array( 'search' => array() ) );
        $this->assertTrue( $helper->displayBrTag() );
    }
    
    function testDefaultDirectory()
    {
        $helper = $this->getHelper( array( 'directory' => array( 'enable' => true ) ) );
        $this->assertTrue( $helper->enableDirectory() );
    }
    
    function testBrTag1()
    {
        $helper = $this->getHelper( array( 'search' => array( 'insertBrTag' => true ) ) );
        $this->assertTrue( $helper->displayBrTag() );
    }
    
    function testBrTag2()
    {
        $helper = $this->getHelper( array( 'search' => array( 'insertBrTag' => false ) ) );
        $this->assertFalse( $helper->displayBrTag() );
    }

    function testLoadingTextDefault()
    {
        $helper = new Elite_Vaf_Helper_Data;
        $helper = $this->getHelper( array( 'search' => array() ) );
        $this->assertEquals( 'loading', $helper->getLoadingText() );
    }
    
    function testLoadingText()
    {
        $helper = new Elite_Vaf_Helper_Data;
        $helper = $this->getHelper( array( 'search' => array( 'loadingText' => 'test' ) ) );
        $this->assertEquals( 'test', $helper->getLoadingText() );
    }
    
    function testLoadingTextBlank()
    {
        $helper = new Elite_Vaf_Helper_Data;
        $helper = $this->getHelper( array( 'search' => array( 'loadingText' => '' ) ) );
        $this->assertEquals( '', $helper->getLoadingText() );
    }
    
}