<?php
class Ne8Vehicle_YearTest extends Elite_Vaf_TestCase
{
    function testShouldNotBeValid()
    {
        $year = new Ne8Vehicle_Year('foo');
        $this->assertFalse( $year->isValid(), 'should not be valid');
    }
    
    function test1DigitYearShouldNotBeValid()
    {
        $year = new Ne8Vehicle_Year('9');
        $this->assertFalse( $year->isValid(), 'one digit year should not be valid');
    }
    
    function test2DigitYearShouldNotBeValidWithWhitespace()
    {
        $year = new Ne8Vehicle_Year('9 ');
        $this->assertFalse( $year->isValid(), 'two digit year should not be valid when one of those "digits" is white space');
    }
    
    function test2DigitYearShouldBeValid()
    {
        $year = new Ne8Vehicle_Year('99');
        $this->assertTrue( $year->isValid(), 'two digit year should be valid');
    }
    
    function test3DigitYearShouldNotBeValid()
    {
        $year = new Ne8Vehicle_Year('999');
        $this->assertFalse( $year->isValid(), 'three digit year should not be valid');
    }
    
    function test4DigitYearShouldBeValid()
    {
        $year = new Ne8Vehicle_Year('1999');
        $this->assertTrue( $year->isValid(), 'four digit year should be valid');
    }
    
    function testWhen2DigitYearLowerThan25ShouldCastTo21stCentury()
    {
        $year = new Ne8Vehicle_Year(24);
        $this->assertEquals( 2024, $year->value(), 'when 2digit year is 24 or less, should cast to 21st century' );
    }
    
    function testWhen2DigitYear25OrGreaterShouldCastTo20thCentury()
    {
        $year = new Ne8Vehicle_Year(25);
        $this->assertEquals( 1925, $year->value(), 'when two digit year is 25 or greater, should cast to 20th century' );
    }
    
    function testWhen2DigitYearLowerThan60ShouldCastTo21stCentury()
    {
        $year = new Ne8Vehicle_Year(55);
        $year->setThreshold(60);
        $this->assertEquals( 2055, $year->value(), 'when 2digit year is 59 or less, should cast to 21st century' );
    }
    
    function testWhen2DigitYear60OrGreaterShouldCastTo20thCentury()
    {
        $year = new Ne8Vehicle_Year(60);
        $year->setThreshold(60);
        $this->assertEquals( 1960, $year->value(), 'when two digit year is 60 or greater, should cast to 20th century' );
    }
    
    /**
    * @expectedException Ne8Vehicle_Year_Exception
    */
    function testShouldThrowExceptionWhenParsingInvalid()
    {
        $year = new Ne8Vehicle_Year('invalid');
        $year->value();
    }
}