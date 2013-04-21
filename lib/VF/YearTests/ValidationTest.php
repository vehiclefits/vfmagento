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
class VF_YearTests_ValidationTest extends PHPUnit_Framework_TestCase
{
    function testShouldNotBeValid()
    {
        $year = new VF_Year('foo');
        $this->assertFalse( $year->isValid(), 'should not be valid');
    }
    
    function test1DigitYearShouldNotBeValid()
    {
        $year = new VF_Year('9');
        $this->assertFalse( $year->isValid(), 'one digit year should not be valid');
    }
    
    function test2DigitYearShouldNotBeValidWithWhitespace()
    {
        $year = new VF_Year('9 ');
        $this->assertFalse( $year->isValid(), 'two digit year should not be valid when one of those "digits" is white space');
    }
    
    function test2DigitYearShouldBeValid()
    {
        $year = new VF_Year('99');
        $this->assertTrue( $year->isValid(), 'two digit year should be valid');
    }
    
    function test3DigitYearShouldNotBeValid()
    {
        $year = new VF_Year('999');
        $this->assertFalse( $year->isValid(), 'three digit year should not be valid');
    }
    
    function test4DigitYearShouldBeValid()
    {
        $year = new VF_Year('1999');
        $this->assertTrue( $year->isValid(), 'four digit year should be valid');
    }
}