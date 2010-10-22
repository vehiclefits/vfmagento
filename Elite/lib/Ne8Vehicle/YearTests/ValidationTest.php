<?php
class Ne8Vehicle_YearTests_ValidationTest extends PHPUnit_Extensions_PerformanceTestCase
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
}