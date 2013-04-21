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
class VF_Import_VehiclesList_CSV_ImportTests_MMCYE_ImportTest extends VF_Import_TestCase
{
    function doSetUp()
    {
		$this->switchSchema('make,model,chassis,years,engine');
    }
    
    function testSameChassis()
    {
        $csvData = 'make,model,engine,chassis,years'; // testing with the levels not in their regular "order"
        $csvData .= "\n";
        $csvData .= 'Honda,Accord,1.6 Luxe,4-doors sedan,1985 to 1989';
        $csvData .= "\n";
        $csvData .= 'Honda,Civic,1.3 Luxe,4-doors sedan,1985 to 1989';
        
        $this->importVehiclesList($csvData);
        
        $this->assertTrue( $this->vehicleExists(array('make'=>'Honda', 'model'=>'Accord', 'engine'=>'1.6 Luxe', 'chassis'=>'4-doors sedan', 'years'=>'1985 to 1989')), 'imports vehicle 1');
        $this->assertTrue( $this->vehicleExists(array('make'=>'Honda', 'model'=>'Civic', 'engine'=>'1.3 Luxe', 'chassis'=>'4-doors sedan', 'years'=>'1985 to 1989')), 'imports vehicle 2');
    }

}