<?php
class Ne8Vehicle_YearTests_ValueTest extends PHPUnit_Extensions_PerformanceTestCase
{
    /**
    * @expectedException Ne8Vehicle_Year_Exception
    */
    function testShouldThrowExceptionWhenParsingInvalid()
    {
        $year = new Ne8Vehicle_Year('invalid');
        $year->value();
    }
    
    function testShouldDisableY2kMode()
    {
        $year = new Ne8Vehicle_Year(24);
        $year->setY2KMode(false);
        $this->assertEquals( 24, $year->value(), 'should disable Y2k Mode' );
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
}