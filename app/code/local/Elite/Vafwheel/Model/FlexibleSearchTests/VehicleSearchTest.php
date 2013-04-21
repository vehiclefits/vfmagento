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

class Elite_Vafwheel_Model_FlexibleSearchTests_VehicleSearchTest extends Elite_Vaf_TestCase
{

    /** @var VF_Vehicle */
    protected $vehicle;

    function doSetUp()
    {
	$this->switchSchema('make,model,year');
	$this->vehicle = $this->createMMY();
	$this->vehicle->save();
    }

    function testShouldBeAbleToSearchByVehicle()
    {
	$product = $this->newWheelProduct(1);
	$product->addVafFit($this->vehicle->toValueArray());
	$_SESSION = $this->vehicle->toValueArray();
	$this->assertEquals(array(1), $this->flexibleWheelSearch()->doGetProductIds(), 'should be able to search by vehicle');
    }

    function testWheelSizeShouldPrecedeVehicleForWheelProducts()
    {
	$product = $this->newWheelProduct(1);
	$product->addBoltPattern($this->boltPattern('5x114.3'));
	$product->addVafFit($this->vehicle->toValueArray());

	$this->setRequestParams(array('lug_count' => '4', 'stud_spread' => '114.3'));
	$_SESSION = $this->vehicle->toValueArray();
	$this->assertEquals(array(0), $this->flexibleWheelSearch()->doGetProductIds(), 'wheel size should precede vehicle for wheel products');
    }

    function testWheelSizeShouldNotPrecedeVehicleForNonWheelProducts()
    {
	$product = $this->newWheelProduct(1);
	$product->addVafFit($this->vehicle->toValueArray());

	$this->setRequestParams(array('lug_count' => '4', 'stud_spread' => '114.3'));
	$_SESSION = $this->vehicle->toValueArray();
	return $this->markTestIncomplete();
	//$this->assertEquals( array(1), $this->flexibleWheelSearch()->doGetProductIds(), 'wheel size should not precede vehicle for non wheel products' );
    }

}
