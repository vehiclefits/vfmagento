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
class VF_Vehicle_FinderTests_SaveTest extends Elite_Vaf_TestCase
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
    
    function testMakeShouldBeGlobal()
    {
        $vehicle1 = $this->createVehicle(array('year'=>'2000', 'make'=>'Honda', 'model'=>'Civic'));
        $vehicle2 = $this->createVehicle(array('year'=>'2001', 'make'=>'Honda', 'model'=>'Civic'));
        $this->assertEquals($vehicle1->getValue('make'), $vehicle2->getValue('make'), 'make should not be unique');
    }
        
    function testShouldPutMakeUnderFirstSavedYear()
    {
        $vehicle1 = $this->createVehicle(array('year'=>'2000', 'make'=>'Honda', 'model'=>'Civic'));
        $this->assertTrue( $this->vehicleExists(array('year'=>'2000', 'make'=>'Honda')), 'should put make "under" first saved year');
    }
            
    function testShouldPutMakeUnderSecondSavedYear()
    {
        $vehicle1 = $this->createVehicle(array('year'=>'2000', 'make'=>'Honda', 'model'=>'Civic'));
        $vehicle2 = $this->createVehicle(array('year'=>'2001', 'make'=>'Honda', 'model'=>'Civic'));
        $this->assertTrue( $this->vehicleExists(array('year'=>'2001', 'make'=>'Honda')), 'should put make "under" second saved year');
    }
    
    function testShouldNotPutMakeUnderWrongYears()
    {
        $vehicle1 = $this->createVehicle(array('year'=>'2000', 'make'=>'Honda', 'model'=>'Civic'));
        $vehicle2 = $this->createVehicle(array('year'=>'2001', 'make'=>'Honda', 'model'=>'Civic'));
        $vehicle3 = $this->createVehicle(array('year'=>'2002', 'make'=>'Acura', 'model'=>'Integra'));
        
        $this->assertFalse( $this->vehicleExists(array('year'=>'2002', 'make'=>'Honda')), 'should not put make "under" wrong years');
    }
    
    function testShouldNotPutModelUnderWrongYears()
    {
        $vehicle1 = $this->createVehicle(array('year'=>'2000', 'make'=>'Honda', 'model'=>'Civic'));
        $vehicle2 = $this->createVehicle(array('year'=>'2001', 'make'=>'Honda', 'model'=>'Accord'));
        
        $this->assertFalse( $this->vehicleExists(array('year'=>'2001', 'make'=>'Honda', 'model'=>'Civic')), 'should not put model "under" wrong years');
    }
}