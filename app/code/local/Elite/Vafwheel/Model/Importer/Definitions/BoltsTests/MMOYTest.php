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
class Elite_Vafwheel_Model_Importer_Definitions_BoltsTests_MMOYTest extends Elite_Vafwheel_Model_Importer_Definitions_BoltsTests_TestCase
{
    protected $csvData;
    protected $csvFile;    

    function doSetUp()
    {
        $this->switchSchema( 'make,model,option,year' );
                
        $this->csvData = 'make, model, option, year_start, year_end, bolt_pattern
honda, civic, EL, 2000, 2002, 4x114.3
acura, integra, base, 2000, 2003, 5x114.3';
        $this->csvFile = TEMP_PATH . '/bolt-definitions-range-MMOY.csv';
        file_put_contents( $this->csvFile, $this->csvData );
        
        $importer = new Elite_Vafwheel_Model_Importer_Definitions_Bolts( $this->csvFile );
        $importer->import();
    }
    
    function testShouldImportLugCount()
    {
        $vehicle = $this->findVehicleByLevelsMMOY( 'honda', 'civic', 'EL', '2000' );
        $this->assertEquals( 4, $vehicle->boltPattern()->lug_count, 'should import lug count' );
    }
  //  
//    function testImport2()
//    {
//        $year = $this->findEntityFromFullPathMMOY( 'honda', 'civic', 'EL', '2001' );
//        $actual = $this->findBolts( $year->getId() );
//        $expected = new stdClass;
//        $expected->lug_count = 4;
//        $expected->bolt_distance = 114.3;
//        $this->assertEquals( $expected, $actual );
//    }
//    
//    function testImport3()
//    {
//        $year = $this->findEntityFromFullPathMMOY( 'honda', 'civic', 'EL', '2002' );
//        $actual = $this->findBolts( $year->getId() );
//        $expected = new stdClass;
//        $expected->lug_count = 4;
//        $expected->bolt_distance = 114.3;
//        $this->assertEquals( $expected, $actual );
//    }
//    
//    function testImport4()
//    {
//        $year = $this->findEntityFromFullPathMMOY( 'acura', 'integra', 'base', '2000' );
//        $actual = $this->findBolts( $year->getId() );
//        $expected = new stdClass;
//        $expected->lug_count = 5;
//        $expected->bolt_distance = 114.3;
//        $this->assertEquals( $expected, $actual );
//    }

}