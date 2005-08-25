<?php
class VF_Year_RangeTests_ValueTest extends PHPUnit_Framework_TestCase
{
    function testShouldDisableY2kModeForStartYear()
    {
        $range = new VF_Year_Range('24-56');
        $range->setY2KMode(false);
        $this->assertEquals( 24, $range->start(), 'should disable Y2k Mode for start year' );
    }
    
    function testShouldDisableY2kModeForEndYear()
    {
        $range = new VF_Year_Range('24-56');
        $range->setY2KMode(false);
        $this->assertEquals( 56, $range->end(), 'should disable Y2k Mode for end year' );
    }
    
    function testShouldUseSingle4DigitYearForStartValue()
    {
        $range = new VF_Year_Range('2004');
        $this->assertEquals( 2004, $range->start(), 'should use single 4 digit year as start year' );
    }
    
    function testShouldUseSingle4DigitYearForEndValue()
    {
        $range = new VF_Year_Range('2004');
        $this->assertEquals( 2004, $range->end(), 'should use single 4 digit year as end year' );
    }
    
    function testShouldUseSingle2DigitYearForStartValue()
    {
        $range = new VF_Year_Range('04');
        $this->assertEquals( 2004, $range->start(), 'should use single 2 digit year as start year' );
    }
    
    function testShouldUseSingle2DigitYearForEndValue()
    {
        $range = new VF_Year_Range('04');
        $this->assertEquals( 2004, $range->end(), 'should use single 2 digit year as end year' );
    }
    
    function testShouldBeTrimSpacesOnStartYear()
    {
        $range = new VF_Year_Range(' 02 - 03 ');
        $this->assertEquals( '02', $range->startInput(), 'should trim spaces on start year' );
    }
    
    function testShouldBeTrimSpacesOnEndYear()
    {
        $range = new VF_Year_Range(' 02 - 03 ');
        $this->assertEquals( '03', $range->endInput(), 'should trim spaces on end year' );
    }
    
    function testShouldGetStart4Digit()
    {
        $range = new VF_Year_Range('2004-2005');
        $this->assertEquals( 2004, $range->start(), 'should get start year' );
    }
    
    function testShouldGetEnd4Digit()
    {
        $range = new VF_Year_Range('2004-2005');
        $this->assertEquals( 2005, $range->end(), 'should get end year' );
    }
    
    function testShouldGetStart2Digit()
    {
        $range = new VF_Year_Range('04-05');
        $this->assertEquals( 2004, $range->start(), 'should get start year' );
    }
    
    function testShouldGetEnd2Digit()
    {
        $range = new VF_Year_Range('04-05');
        $this->assertEquals( 2005, $range->end(), 'should get end year' );
    }
    
    function testShouldUseStartWhenEndBlank()
    {
        $range = new VF_Year_Range('04-');
        $this->assertEquals( 2004, $range->end(), 'should use start when end is blank' );
    }
    
    function testShouldUseEndWhenStartBlank()
    {
        $range = new VF_Year_Range('-04');
        $this->assertEquals( 2004, $range->start(), 'should use end when start is blank' );
    }
    
    function testShouldUseCenturyThreshold_EndYear()
    {
        $range = new VF_Year_Range('20-40');
        $range->setThreshold(41);
        $this->assertEquals( 2040, $range->end(), 'should use century threshold on end year' );
    }
    
    function testShouldUseCenturyThreshold_StartYear()
    {
        $range = new VF_Year_Range('20-40');
        $range->setThreshold(21);
        $this->assertEquals( 2020, $range->start(), 'should use century threshold on start year' );
    }
}