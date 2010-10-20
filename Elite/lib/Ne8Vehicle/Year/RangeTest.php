<?php
class Ne8Vehicle_Year_RangeTest extends Elite_Vaf_TestCase
{
    function testShouldBeInvalid_BlankString()
    {
        $range = new Ne8Vehicle_Year_Range('');
        $this->assertFalse( $range->isValid(), 'should be invalid when blank string is passed' );
    }
    
    function testShouldBeInvalid_String()
    {
        $range = new Ne8Vehicle_Year_Range('foo');
        $this->assertFalse( $range->isValid(), 'should be invalid when string is passed' );
    }
    
    function shouldUseSingle4DigitYearForStartValue()
    {
        $range = new Ne8Vehicle_Year_Range('2004');
        $this->assertEquals( 2004, $range->start(), 'should use single 4 digit year as start year' );
    }
    
    function shouldUseSingle4DigitYearForSEndValue()
    {
        $range = new Ne8Vehicle_Year_Range('2004');
        $this->assertEquals( 2004, $range->end(), 'should use single 4 digit year as end year' );
    }
    
    function shouldUseSingle2DigitYearForStartValue()
    {
        $range = new Ne8Vehicle_Year_Range('04');
        $this->assertEquals( 2004, $range->start(), 'should use single 2 digit year as start year' );
    }
    
    function shouldUseSingle2DigitYearForSEndValue()
    {
        $range = new Ne8Vehicle_Year_Range('04');
        $this->assertEquals( 2004, $range->end(), 'should use single 2 digit year as end year' );
    }
    
    function testShouldBeValid_2DigitYears()
    {
        $range = new Ne8Vehicle_Year_Range('02-03');
        $this->assertTrue( $range->isValid(), 'should be valid with 2 digit years' );
    }
    
    function testShouldBeValid_1DigitEndYear()
    {
        $range = new Ne8Vehicle_Year_Range('02-3');
        $this->assertFalse( $range->isValid(), 'should be invalid with 1 digit end year' );
    }
    
    function testShouldBeValid_1DigitStartYear()
    {
        $range = new Ne8Vehicle_Year_Range('2-34');
        $this->assertFalse( $range->isValid(), 'should be invalid with 1 digit start year' );
    }
    
    function test4DigitStartShouldBeValid()
    {
        $range = new Ne8Vehicle_Year_Range('2004-');
        $this->assertTrue( $range->isValid(), '4 digit start year should be valid range' );
    }
    
    function test4DigitEndShouldBeValid()
    {
        $range = new Ne8Vehicle_Year_Range('-2005');
        $this->assertTrue( $range->isValid(), '4 digit end year should be valid range' );
    }
    
    function testShouldGetStart4Digit()
    {
        $range = new Ne8Vehicle_Year_Range('2004-2005');
        $this->assertEquals( 2004, $range->start(), 'should get start year' );
    }
    
    function testShouldGetEnd4Digit()
    {
        $range = new Ne8Vehicle_Year_Range('2004-2005');
        $this->assertEquals( 2005, $range->end(), 'should get end year' );
    }
    
    function testShouldGetStart2Digit()
    {
        $range = new Ne8Vehicle_Year_Range('04-05');
        $this->assertEquals( 2004, $range->start(), 'should get start year' );
    }
    
    function testShouldGetEnd2Digit()
    {
        $range = new Ne8Vehicle_Year_Range('04-05');
        $this->assertEquals( 2005, $range->end(), 'should get end year' );
    }
    
    function testShouldUseStartWhenEndBlank()
    {
        $range = new Ne8Vehicle_Year_Range('04-');
        $this->assertEquals( 2004, $range->end(), 'should use start when end is blank' );
    }
    
    function testShouldUseEndWhenStartBlank()
    {
        $range = new Ne8Vehicle_Year_Range('-04');
        $this->assertEquals( 2004, $range->start(), 'should use end when start is blank' );
    }
}