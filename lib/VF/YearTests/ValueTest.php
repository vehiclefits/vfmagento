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
class VF_YearTests_ValueTest extends PHPUnit_Framework_TestCase
{
    /**
    * @expectedException VF_Year_Exception
    */
    function testShouldThrowExceptionWhenParsingInvalid()
    {
        $year = new VF_Year('invalid');
        $year->value();
    }
    
    function testShouldDisableY2kMode()
    {
        $year = new VF_Year(24);
        $year->setY2KMode(false);
        $this->assertEquals( 24, $year->value(), 'should disable Y2k Mode' );
    }
    
    function testWhen2DigitYearLowerThan25ShouldCastTo21stCentury()
    {
        $year = new VF_Year(24);
        $this->assertEquals( 2024, $year->value(), 'when 2digit year is 24 or less, should cast to 21st century' );
    }
    
    function testWhen2DigitYear25OrGreaterShouldCastTo20thCentury()
    {
        $year = new VF_Year(25);
        $this->assertEquals( 1925, $year->value(), 'when two digit year is 25 or greater, should cast to 20th century' );
    }
    
    function testWhen2DigitYearLowerThan60ShouldCastTo21stCentury()
    {
        $year = new VF_Year(55);
        $year->setThreshold(60);
        $this->assertEquals( 2055, $year->value(), 'when 2digit year is 59 or less, should cast to 21st century' );
    }
    
    function testWhen2DigitYear60OrGreaterShouldCastTo20thCentury()
    {
        $year = new VF_Year(60);
        $year->setThreshold(60);
        $this->assertEquals( 1960, $year->value(), 'when two digit year is 60 or greater, should cast to 20th century' );
    }
}