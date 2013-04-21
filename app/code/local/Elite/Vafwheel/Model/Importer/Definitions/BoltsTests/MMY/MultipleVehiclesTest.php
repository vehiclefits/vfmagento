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
class Elite_Vafwheel_Model_Importer_Definitions_BoltsTests_MMY_MultipleVehiclesTest extends Elite_Vafwheel_Model_Importer_Definitions_BoltsTests_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testShouldImportHondaLugCount()
    {
        $this->importVehicleBolts(
            '"make","model","year","bolt pattern"' . "\n" .
            'honda, civic, 2000, 4x114.3' . "\n" .
            'acura, integra, 2000, 5x117.3');
        $vehicle = $this->findVehicleByLevelsMMY( 'honda', 'civic', '2000' );
        $this->assertEquals( 4, $vehicle->boltPattern()->lug_count, 'should import lug count for honda' );
    }
    
    function testShouldImportHondaBoltDistance()
    {
        $this->importVehicleBolts(
            '"make","model","year","bolt pattern"' . "\n" .
            'honda, civic, 2000, 4x114.3' . "\n" .
            'acura, integra, 2000, 5x117.3');
        $vehicle = $this->findVehicleByLevelsMMY( 'honda', 'civic', '2000' );
        $this->assertEquals( 114.3, $vehicle->boltPattern()->bolt_distance, 'should import bolt distance for honda' );
    }
    
    function testShouldImportAcuraLugCount()
    {
        $this->importVehicleBolts(
            '"make","model","year","bolt pattern"' . "\n" .
            'honda, civic, 2000, 4x114.3' . "\n" .
            'acura, integra, 2000, 5x117.3');
        $vehicle = $this->findVehicleByLevelsMMY( 'acura', 'integra', '2000' );
        $this->assertEquals( 5, $vehicle->boltPattern()->lug_count, 'should import lug count for acura' );
    }
    
    function testShouldImportAcuraBoltDistance()
    {
        $this->importVehicleBolts(
            '"make","model","year","bolt pattern"' . "\n" .
            'honda, civic, 2000, 4x114.3' . "\n" .
            'acura, integra, 2000, 5x117.3');
        $vehicle = $this->findVehicleByLevelsMMY( 'acura', 'integra', '2000' );
        $this->assertEquals( 117.3, $vehicle->boltPattern()->bolt_distance, 'should import bolt distance for acura' );
    }
}
