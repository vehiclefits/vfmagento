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
class Elite_Vaftire_Model_Importer_Definitions_TireSizeTests_MMY_MultipleSizesOnSingleVehicleTest extends Elite_Vaftire_Model_Importer_Definitions_TireSizeTests_MMY_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testShouldImportMultipleSizesOnSingleVehicle()
    {
        $this->importVehicleTireSizes(
            '"make","model","year","tire_size"' . "\n" .
            'honda, civic, 2000, 215/60-15' . "\n" . 
            'honda, civic, 2000, 215/60-16');
        $vehicle = $this->findVehicleByLevelsMMY('honda','civic','2000');
        $this->assertEquals( 2, count($vehicle->tireSize()), 'should import multiple tire sizes' );
    }
    
    function testShouldSkipDuplicates()
    {
        $this->importVehicleTireSizes(
            '"make","model","year","tire_size"' . "\n" .
            'honda, civic, 2000, 215/60-15' . "\n" . 
            'honda, civic, 2000, 215/60-15');
        $vehicle = $this->findVehicleByLevelsMMY('honda','civic','2000');
        $this->assertEquals( 1, count($vehicle->tireSize()), 'should skip duplicate sizes for the same vehicle' );
    }
}