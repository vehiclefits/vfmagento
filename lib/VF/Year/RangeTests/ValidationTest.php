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
class VF_Year_RangeTests_ValidationTest extends PHPUnit_Framework_TestCase
{
    function testShouldBeInvalid_BlankString()
    {
        $range = new VF_Year_Range('');
        $this->assertFalse( $range->isValid(), 'should be invalid when blank string is passed' );
    }
    
    function testShouldBeInvalid_String()
    {
        $range = new VF_Year_Range('foo');
        $this->assertFalse( $range->isValid(), 'should be invalid when string is passed' );
    }
    
    function testShouldBeInvalid_StringWithDash()
    {
        $range = new VF_Year_Range('foo-bar');
        $this->assertFalse( $range->isValid(), 'should be invalid when string is passed with dash' );
    }
    
    function testSingle2DigitYearShouldBeValid()
    {
        $range = new VF_Year_Range('04');
        $this->assertTrue($range->isValid(), 'single 2 digit year should be valid');
    }
    
    function testShouldSingle4DigitYearShouldBeValid()
    {
        $range = new VF_Year_Range('2004');
        $this->assertTrue($range->isValid(), 'single 4 digit year should be valid');
    }
    
    function testShouldSingle4DigitYearShouldBeValid_TrimSpace()
    {
        $range = new VF_Year_Range('2004 ');
        $this->assertTrue($range->isValid(), 'single 4 digit year should be valid (with trailing space)');
    }
    
    function testShouldBeValid_2DigitYears()
    {
        $range = new VF_Year_Range('02-03');
        $this->assertTrue( $range->isValid(), 'should be valid with 2 digit years' );
    }
    
    function testShouldBeValidWithWhiteSpaces()
    {
        $range = new VF_Year_Range(' 02 - 03 ');
        $this->assertTrue( $range->isValid(), 'should trim spaces' );
    }
    
    function testShouldBeValid_1DigitEndYear()
    {
        $range = new VF_Year_Range('02-3');
        $this->assertFalse( $range->isValid(), 'should be invalid with 1 digit end year' );
    }
    
    function testShouldBeValid_1DigitStartYear()
    {
        $range = new VF_Year_Range('2-34');
        $this->assertFalse( $range->isValid(), 'should be invalid with 1 digit start year' );
    }
    
    function test4DigitStartShouldBeValid()
    {
        $range = new VF_Year_Range('2004-');
        $this->assertTrue( $range->isValid(), '4 digit start year should be valid range' );
    }
    
    function test4DigitEndShouldBeValid()
    {
        $range = new VF_Year_Range('-2005');
        $this->assertTrue( $range->isValid(), '4 digit end year should be valid range' );
    }
}