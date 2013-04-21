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
class VF_Import_VehiclesList_CSV_ImportTests_SimpleTest extends VF_Import_TestCase
{

    protected $csvData;
    protected $csvFile;

    function doSetUp()
    {
        $this->switchSchema('make,model,option,year');
        
        $this->csvData = 'make, model, option, year
honda, civic, base, 2000
honda, civic, base, 2001
honda, civic, base, 2002
acura, integra, base, 2000';
    }
    
    function testShouldImportMake()
    {
        $this->importVehiclesList($this->csvData);
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda')), 'importer should be able to load makes (root levels) properly' );
    }
    
    function testShouldImportMake2()
    {
        $this->importVehiclesList($this->csvData);
        $this->assertTrue( $this->vehicleExists(array('make'=>'acura')), 'importer should be able to load makes (root levels) properly' );
    }
    
    function testWhenImportingMultipleTimesShouldSkipDuplicates()
    {
        $this->importVehiclesList($this->csvData);
        $expected_id = $this->levelFinder()->findEntityIdByTitle('make','honda');
        
        $this->importVehiclesList($this->csvData);
        $actual_id = $this->levelFinder()->findEntityIdByTitle( 'make', 'honda' );
        $this->assertEquals( $expected_id, $actual_id, 'when importing multiple times should skip duplicates' );
    }
    
    function testShouldImportYear2000()
    {
        $this->importVehiclesList($this->csvData);
        $this->assertTrue( $this->vehicleExists(array('year'=>'2000')), 'should import year 2000' );
    }
    
    function testShouldImportYear2001()
    {
        $this->importVehiclesList($this->csvData);
        $this->assertTrue( $this->vehicleExists(array('year'=>'2001')), 'should import year 2001' );
    }
    
    function testShouldImportYear2002()
    {
        $this->importVehiclesList($this->csvData);
        $this->assertTrue( $this->vehicleExists(array('year'=>'2002')), 'should import year 2002' );
    }

}