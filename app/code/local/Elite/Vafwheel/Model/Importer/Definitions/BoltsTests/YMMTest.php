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
class Elite_Vafwheel_Model_Importer_Definitions_BoltsTests_YMMTest extends Elite_Vafwheel_Model_Importer_Definitions_BoltsTests_TestCase
{
    protected $csvData;
    protected $csvFile;
    
    function doSetUp()
    {
        $this->switchSchema('year,make,model');
        
        $this->csvData = '"make","model","year_start","year_end","bolt pattern"
honda, civic, 2000, 2002, 1x114.3
acura, integra, 2000, 2003, 2x114.3';
        $this->csvFile = TEMP_PATH . '/bolt-definitions-range.csv';
        file_put_contents( $this->csvFile, $this->csvData );
        
        $importer = new Elite_Vafwheel_Model_Importer_Definitions_Bolts( $this->csvFile );
        $importer->import();
    }
    
    function testShouldImportLugCount()
    {
        $vehicle = $this->findVehicleByLevelsYMM( '2000', 'honda', 'civic' );
        $this->assertEquals( 1, $vehicle->boltPattern()->lug_count, 'should import lug count' );
    }

    function testShouldImportBoltDistance()
    {
        $vehicle = $this->findVehicleByLevelsYMM( '2000', 'honda', 'civic' );
        $this->assertEquals( 114.3, $vehicle->boltPattern()->bolt_distance, 'should import bolt distance' );
    }

}