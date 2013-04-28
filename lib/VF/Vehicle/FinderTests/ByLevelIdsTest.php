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

class VF_Vehicle_FinderTests_ByLevelIdsTest extends VF_Vehicle_FinderTests_TestCase
{

    function testShouldFindByAllLevels()
    {
        $vehicle = $this->createMMY('Honda', 'Civic', '2000');
        $vehicles = $this->getFinder()->findByLevelIds($vehicle->toValueArray());
        $this->assertEquals(1, count($vehicles), 'should find by levels');
    }

    function testShouldFindByMake()
    {
        $vehicle = $this->createMMY('Honda', 'Civic', '2000');
        $vehicles = $this->getFinder()->findByLevelIds(array('make' => $vehicle->getValue('make')));
        $this->assertEquals(1, count($vehicles), 'should find by make');
    }

    function testShouldFindByMakeAlternateParamaterStyle()
    {
        $vehicle = $this->createMMY('Honda', 'Civic', '2000');
        $vehicles = $this->getFinder()->findByLevelIds(array('make_id' => $vehicle->getValue('make')));
        $this->assertEquals(1, count($vehicles), 'should find by make w/ alternative paramater style (make_id)');
    }

    function testShouldFindOneByLevelIds()
    {
        $vehicle = $this->createMMY('Honda', 'Civic', '2000');

        $vehicle2 = $this->getFinder()->findOneByLevelIds(array('make_id' => $vehicle->getValue('make')));
        $this->assertEquals($vehicle->toValueArray(), $vehicle2->toValueArray(), 'should find one by level ids');
    }

    function testShouldNotFindOneByLevelIds()
    {
        $vehicle2 = $this->getFinder()->findOneByLevelIds(array('make_id' => 1));
        $this->assertFalse($vehicle2, 'should not find one by level ids');
    }

    function testShouldFindInSecondSchema()
    {
        $schema = VF_Schema::create('foo,bar');
        $vehicle = $this->createVehicle(array('foo'=>'123','bar'=>'456'),$schema);
        $found = $this->getFinder($schema)->findOneByLevelIds(array('foo'=>$vehicle->getValue('foo')));
        $this->assertEquals($vehicle->getValue('foo'), $found->getValue('foo'), 'should find in second schema');
    }

}