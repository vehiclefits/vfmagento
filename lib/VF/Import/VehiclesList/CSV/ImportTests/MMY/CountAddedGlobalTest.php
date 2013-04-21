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
class VF_Import_VehiclesList_CSV_ImportTests_MMY_CountAddedGlobalTest extends VF_Import_TestCase
{    
    function doSetUp()
    {
        $schemaGenerator = new VF_Schema_Generator();
        $schemaGenerator->dropExistingTables();
        $schemaGenerator->execute(array(
            'year',
            'make' => array('global'=>true),
            'model'
        ));
        $this->startTransaction();
    }
    
    function doTearDown()
    {
        $schemaGenerator = new VF_Schema_Generator();
        $schemaGenerator->dropExistingTables();
    }
    
    function testShouldAddTwoModels()
    {
        $importer = $this->importVehiclesList('make, model, year' . "\n" .
                                              'honda, integra, 2000' . "\n" .
                                              'acura, integra, 2000');
                                              
        $this->assertEquals( 2, $importer->getCountAddedByLevel('model'), 'should add two models' );
    }
    
    function testShouldAddYear()
    {
        $importer = $this->importVehiclesList('make, model, year' . "\n" .
                                              'acura, integra, 2000');
                                              
        $this->assertEquals( 1, $importer->getCountAddedByLevel('year'), 'should add year' );
    }
    
    function testShouldCountUniqueYears()
    {
        $importer = $this->importVehiclesList('make, model, year' . "\n" .
                                              'honda, civic, 2000' . "\n" .
                                              'acura, integra, 2000');
                                              
        $this->assertEquals( 1, $importer->getCountAddedByLevel('year'), 'should count unique years' );
    }
    
    function testShouldCountVehiclesAdded()
    {
        $importer = $this->importVehiclesList('make, model, year' . "\n" .
                                              'honda, civic, 2000' . "\n" .
                                              'acura, integra, 2000');
                                              
        $this->assertEquals( 2, $importer->getCountAddedVehicles(), 'should count added vehicles' );
    }
    
    function testShouldCount0Added()
    {
        $importer = $this->importVehiclesListTwice('make, model, year' . "\n" .
                                              'honda, civic, 2000' . "\n" .
                                              'acura, integra, 2000');
                                              
        $this->assertEquals( 0, $importer->getCountAddedVehicles(), 'should count 0 added (should not count something we already had)' );
    }
    
}