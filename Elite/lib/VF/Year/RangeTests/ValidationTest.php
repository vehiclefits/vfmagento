<?php
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