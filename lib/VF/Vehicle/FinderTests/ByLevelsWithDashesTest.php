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
class VF_Vehicle_FinderTests_ByLevelsWithDashesTest extends VF_Vehicle_FinderTests_TestCase
{
	function testWithoutDash()
    {
        $this->createMMY( 'Honda', 'All Models', '2000' );
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'Honda','model'=>'All Models','year'=>2000));
        $this->assertEquals(1,count($vehicles));
    }
    
    function testShouldReplaceDashesWithSpaces()
    {
        $this->createMMY( 'Honda', 'All Models', '2000' );
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'Honda','model'=>'All-Models','year'=>2000));
        $this->assertEquals(1,count($vehicles),'should replace dashes with spaces');
    }
    
    function testShouldExcludeDifferentYear()
    {
        $this->createMMY( 'Honda', 'All-Models', '2001' );
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'Honda','model'=>'All-Models','year'=>2000));
        $this->assertEquals(0,count($vehicles),'should exclude different years');
    }
    
    function testShouldExcludeDifferentModel()
    {
        $this->createMMY( 'Honda', 'All-Models', '2001' );
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'Honda','model'=>'All-','year'=>2001));
        $this->assertEquals(0,count($vehicles),'should exclude different models');
    }
    
    function testShouldExcludeDifferentModel2()
    {
        $this->createMMY( 'Honda', 'All-Models', '2001' );
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'Honda','model'=>'-Models','year'=>2001));
        $this->assertEquals(0,count($vehicles),'should exclude different models');
    }
    
    function testShouldInterchangeDashAndSpaces()
    {
        $this->createMMY( 'Ford', 'F-150 Super Duty', '2000' );
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'Ford','model'=>'F-150 Super-Duty','year'=>2000));
        $this->assertEquals(1,count($vehicles),'should interchange dashes & spaces');
    }
    
}