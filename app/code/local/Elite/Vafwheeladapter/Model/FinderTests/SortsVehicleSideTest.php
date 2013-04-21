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
class Elite_Vafwheeladapter_Model_FinderTests_SortsVehicleSideTest extends Elite_Vaf_TestCase
{
	function testShouldSortLugCount()
    {
    	$product = $this->newWheeladapterProduct(1);
        $product->addVehicleSideBoltPattern($this->boltPattern('5x114.3'));
        
        $product = $this->newWheeladapterProduct(2);
        $product->addVehicleSideBoltPattern($this->boltPattern('4x114.2'));
        
        $actual = array_values($this->wheelAdapterFinder()->listVehicleSideLugCounts());
        $this->assertEquals( '4', $actual[0], 'should sort lug counts' );
        $this->assertEquals( '5', $actual[1], 'should sort lug counts' );
	}
	
	function testShouldSortStudSpread()
    {
    	$product = $this->newWheeladapterProduct(1);
        $product->addVehicleSideBoltPattern($this->boltPattern('4x114.3'));
        
        $product = $this->newWheeladapterProduct(2);
        $product->addVehicleSideBoltPattern($this->boltPattern('4x114.2'));
        
        $actual = array_values($this->wheelAdapterFinder()->listVehicleSideSpread());
        $this->assertEquals( '114.2', $actual[0], 'should sort stud spread' );
        $this->assertEquals( '114.3', $actual[1], 'should sort stud spread' );
	}
}