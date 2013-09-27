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
 * to sales@vehiclefits.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Elite_Vafwheeladapter_Model_FinderTests_FindsWheelSideTest extends Elite_TestCase
{
    function testFindsLugCount()
    {
    	$product = $this->newWheeladapterProduct(1);
        $product->setWheelSideBoltPattern($this->boltPattern('4x114.3'));
        
        $product = $this->newWheeladapterProduct(2);
        $product->setWheelSideBoltPattern($this->boltPattern('5x114.3'));
        
        $this->assertEquals( array(4=>4, 5=>5), $this->wheelAdapterFinder()->listWheelSideLugCounts(), 'should list possible wheel side lug counts' );
	}
	
	function testFindsSpread()
    {
    	$product = $this->newWheeladapterProduct();
        $product->setId(1);
        $product->setWheelSideBoltPattern($this->boltPattern('4x114.3'));
        
        $product = $this->newWheeladapterProduct();
        $product->setId(2);
        $product->setWheelSideBoltPattern($this->boltPattern('4x117.3'));
        
        $this->assertEquals( array('114.3'=>114.3, '117.3'=>117.3), $this->wheelAdapterFinder()->listWheelSideSpread(), 'should list possible wheel side lug counts' );
	}
	
}