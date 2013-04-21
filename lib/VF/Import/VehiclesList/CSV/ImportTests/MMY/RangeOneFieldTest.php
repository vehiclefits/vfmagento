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
class VF_Import_VehiclesList_CSV_ImportTests_MMY_RangeOneFieldTest extends VF_Import_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testSingleYear()
    {
        $this->importVehiclesList('make, model, year_range' . "\n" .
                                  'honda, civic, 2000');
        
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'civic', 'year'=>'2000')) );
    }
    
    function testYearRange()
    {
        $this->importVehiclesList('make, model, year_range' . "\n" .
                                  'honda, civic, 2000-2002');
        
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'civic', 'year'=>'2000')) );
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'civic', 'year'=>'2002')) );
    }
    
    function testShouldReverseYears()
    {
        $this->importVehiclesList('make, model, year_range' . "\n" .
                                  'honda, accord, 2006-2003');
                                  
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'accord', 'year'=>'2003')) );
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'accord', 'year'=>'2006')) );
    }
    
    
}
