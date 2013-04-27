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
class VF_VehicleMultipleSchemaTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }

    function testVehicleShouldHaveRightSchema()
    {
        $schema = VF_Schema::create('foo,bar');
        $vehicle = VF_Vehicle::create($schema, array('foo'=>'valfoo','bar'=>'valbar'));
        $this->assertEquals($schema->id(), $vehicle->schema()->id(), 'vehicle should have right schema');
    }

    function testLevelsShouldHaveRightSchema()
    {
        $schema = VF_Schema::create('foo,bar');
        $vehicle = VF_Vehicle::create($schema, array('foo'=>'valfoo','bar'=>'valbar'));
        $this->assertEquals($schema->id(), $vehicle->getLevel('foo')->getSchema()->id(), 'levels should have right schema');
    }

    function testShouldSaveLevel()
    {
        $schema = VF_Schema::create('foo,bar');
        $vehicle = VF_Vehicle::create($schema, array('foo'=>'valfoo','bar'=>'valbar'));
        $vehicle->save();

        $levelFinder = new VF_Level_Finder($schema);
        $foundLevel = $levelFinder->find('foo', $vehicle->getValue('foo'));

        $this->assertEquals($vehicle->getValue('foo'), $foundLevel->getId(), 'should save & find level');
    }
    
    function testSaveParenetheses()
    {
        $schema = VF_Schema::create('foo,bar');
        $vehicle = VF_Vehicle::create($schema, array('foo'=>'valfoo','bar'=>'valbar'));
	    $vehicle->save();

        $vehicleExists = $this->vehicleExists(array('foo'=>'valfoo','bar'=>'valbar'), false, $schema);
        $this->assertTrue($vehicleExists, 'should find vehicles in different schema' );
    }
    
}