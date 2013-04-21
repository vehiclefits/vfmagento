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
class VF_Import_VehiclesList_CSV_ImportTests_MMY_SimpleTest extends VF_Import_TestCase
{

    protected $csvData;

    function doSetUp()
    {
        $this->switchSchema('make,model,year');
        
        $this->csvData = 'make, model, year
honda, civic, 2000
honda, civic, 2001
honda, civic, 2002
acura, integra, 2000';
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
    
    function testSameMakeDifferentModel()
    {
        $this->importVehiclesList( "make, model, year\n" .
            "makeA,modelA,2000\n" .
            "makeB,modelA,2000");
        
        $makeA = new VF_Level( 'make', $this->levelFinder()->findEntityIdByTitle( 'make', 'makeA' ) );
        $makeB = new VF_Level( 'make', $this->levelFinder()->findEntityIdByTitle( 'make', 'makeB' ) );
        
        $this->assertEquals( 1, count($makeA->getChildren()), 'when a model name is not unique, should be stored under the proper parent' );
        $this->assertEquals( 1, count($makeB->getChildren()), 'when a model name is not unique, should be stored under the proper parent' );
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