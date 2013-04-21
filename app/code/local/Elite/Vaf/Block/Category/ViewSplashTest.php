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
class Elite_Vaf_Block_Category_ViewSplashTest extends Elite_Vaf_TestCase
{
    function testWhenNoCategoriesRequireVehicleShouldNotShowSplash()
    {
        $categoryView = new Elite_Vaf_Block_Category_View;
        $categoryView->setCategoryId(1);
        $this->assertShouldNotShowSplash( $categoryView, 'when no categories require vehicle should not show splash' );
    }

    function testWhenCategoryRequiresVehicleAndNoVehicleSelectedShouldShowSplash()
    {
        $config = new Zend_Config( array('category'=>array('requireVehicle'=>'1')) );
        $categoryView = new Elite_Vaf_Block_Category_View_SubClass;
        $categoryView->setConfig($config);
        $categoryView->setCategoryId(1);
        $this->assertEquals( 'vf/vaf/splash.phtml', $categoryView->getTemplate() );
        $this->assertShouldShowSplash( $categoryView, 'when category requires a vehicle & no vehicle is selected, should show the splash page' );
    }

    function test_GroupMode_ShouldShowSplash()
    {
        $config = new Zend_Config( array('category'=>array('mode'=>'group','requireVehicle'=>'1')) );
        $categoryView = new Elite_Vaf_Block_Category_View_SubClass;
        $categoryView->setConfig($config);
        $categoryView->setCategoryId(1);
        $this->assertEquals( 'vf/vaf/splash.phtml', $categoryView->getTemplate(), 'when category is in group mode should show splash page' );
    }

    function testWhenWildcardAndNoVehicleSelectedShouldShowSplash()
    {
        $config = new Zend_Config( array('category'=>array('requireVehicle'=>'all')) );
        $categoryView = new Elite_Vaf_Block_Category_View;
        $categoryView->setConfig($config);
        $categoryView->setCategoryId(1);
        $this->assertShouldShowSplash( $categoryView, 'when category requires a vehicle & no vehicle is selected, should show the splash page' );
    }

    function testWhenCategoryDoesntRequireVehicleAndNoVehicleSelectedShouldNotShowSplash()
    {
        $config = new Zend_Config( array('category'=>array('requireVehicle'=>'')) );
        $categoryView = new Elite_Vaf_Block_Category_View;
        $categoryView->setConfig($config);
        $categoryView->setCategoryId(1);
        $this->assertShouldNotShowSplash( $categoryView, 'when category doesnt require a vehicle & no vehicle is selected, should not show the splash page' );
    }

    function testWhenVehicleSelectedShouldNotShowSplash()
    {
        $vehicle = $this->createMMY();
        $_SESSION[ 'make' ] = $vehicle->getLevel('make')->getId();
        $_SESSION[ 'model' ] = $vehicle->getLevel('model')->getId();
        $_SESSION[ 'year' ] = $vehicle->getLevel('year')->getId();

        $config = new Zend_Config( array('category'=>array('requireVehicle'=>'1')) );
        $categoryView = new Elite_Vaf_Block_Category_View;
        $categoryView->setConfig($config);
        $categoryView->setCategoryId(1);
        $this->assertShouldNotShowSplash( $categoryView, 'when vehicle is selected, should not show the splash page' );
    }


    function testWhenVehicleSelected_AndISWildcard_ShouldNotShowSplash()
    {
        $vehicle = $this->createMMY();
        $_SESSION[ 'make' ] = $vehicle->getLevel('make')->getId();
        $_SESSION[ 'model' ] = $vehicle->getLevel('model')->getId();
        $_SESSION[ 'year' ] = $vehicle->getLevel('year')->getId();

        $config = new Zend_Config( array('category'=>array('requireVehicle'=>'all')) );
        $categoryView = new Elite_Vaf_Block_Category_View;
        $categoryView->setConfig($config);
        $categoryView->setCategoryId(1);
        $this->assertShouldNotShowSplash( $categoryView, 'when vehicle is selected (and "is wildcard"), should not show the splash page' );
    }

    function assertShouldShowSplash($categoryView,$message)
    {
        $this->assertTrue( $categoryView->shouldShowSplash(), $message );
    }

    function assertShouldNotShowSplash($categoryView,$message)
    {
        $this->assertFalse( $categoryView->shouldShowSplash(), $message );
    }

}

class Elite_Vaf_Block_Category_View_SubClass extends Elite_Vaf_Block_Category_View
{
    function disableLayeredNavigation() {}
}