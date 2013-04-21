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
class VF_Import_VehiclesList_CSV_ImportTests_MMY_RangeTest extends VF_Import_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testYearRangeFields()
    {
        $importer = $this->vehiclesListImporter('make, model, year_start, year_end');    
        $this->assertEquals( array('make'=>0, 'model'=>1, 'year_start'=>2, 'year_end'=>3 ), $importer->getFieldPositions(), 'should find field positions' );
    }
    
    function testYearRange()
    {
        $this->importVehiclesList('make, model, year_start, year_end' . "\n" .
                                  'honda, civic, 2000, 2002');
                                  
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'civic', 'year'=>'2000')), 'should add all years within range' );
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'civic', 'year'=>'2002')), 'should add all years within range' );
    }
    
    function testYearRange2Digit()
    {
        $this->importVehiclesList('make, model, year_start, year_end' . "\n" .
                                  'honda, civic, 00, 02');
                                  
                                  
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'civic', 'year'=>'2000')), 'should add all 2 digit years within range' );
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'civic', 'year'=>'2002')), 'should add all 2 digit years within range' );
    }
    
    function testYearEndGreaterThanYearStart()
    {
        $this->importVehiclesList('make, model, year_start, year_end' . "\n" .
                                  'honda, accord, 2003, 2000');
                                  
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'accord', 'year'=>'2000')), 'should reverse years' );
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'accord', 'year'=>'2003')), 'should reverse years' );
    }

    function testShouldTrimSpaceInFieldName()
    {
        $this->importVehiclesList('make, model, year_start, "year_end "' . "\n" .
                                  'honda, accord, 2003, 2000');
        
        $this->assertTrue( $this->vehicleExists(array('year'=>'2000')), 'should trim space in field name' );
        $this->assertTrue( $this->vehicleExists(array('year'=>'2003')), 'should trim space in field name' );
    }

    function testYearEndOmitted()
    {
        $this->importVehiclesList('make, model, year_start, "year_end "' . "\n" .
                                  'honda, accord, 2003, ');

        $this->assertTrue( $this->vehicleExists(array('year'=>'2003')), 'if year end is omitted should use year_start as year_end value' );
        $this->assertFalse( $this->vehicleExists(array('year'=>'2004')), 'if year end is omitted should use year_start as year_end value' );
    }
    
    function testYearStartOmitted()
    {
        $this->importVehiclesList('make, model, year_start, "year_end "' . "\n" .
                                  'honda, accord, , 2003');
                                  
        $this->assertTrue( $this->vehicleExists(array('year'=>'2003' )), 'if year start is omitted should use year_end as year_start value' );
        $this->assertFalse( $this->vehicleExists(array('year'=>'2004')), 'if year start is omitted should use year_end as year_start value' );
    }
    
}
