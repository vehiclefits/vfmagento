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
class Elite_Vafwheeladapter_Model_FlexibleSearchTests_FilterTests_WheelSideTest extends Elite_Vaf_TestCase
{
	function testShouldFilterOnWheelSide()
    {
        $product = $this->newWheelAdapterProduct();
        $product->setId(1);
        
        $product->setWheelSideBoltPattern($this->boltPattern('4x114.3'));
        
        $params = array('wheel_lug_count'=>'4', 'wheel_stud_spread'=>'114.3');
        $this->setRequestParams($params);
        
        $flexibleSearch = $this->flexibleWheeladapterSearch($params);
        $this->assertEquals( array(1), $flexibleSearch->doGetProductIds(), 'should filter on wheel side' );
    }
    
    function testShouldFilterOnVehicleSelection()
    {
		$vehicle = $this->createMMY();
		
		$product = $this->newWheelAdapterProduct();
        $product->setId(1);
        $product->addVafFit( $vehicle->toValueArray() );
        
        $product->setWheelSideBoltPattern($this->boltPattern('4x114.3'));
        
        $params = $vehicle->toValueArray() + array('wheel_lug_count'=>'4', 'wheel_stud_spread'=>'114.3');
        $this->setRequestParams($params);
        
        $flexibleSearch = $this->flexibleWheeladapterSearch($params);
        $this->assertEquals( array(1), $flexibleSearch->doGetProductIds(), 'should filter on wheel side' );
    }
    
    function testShouldOmitDifferentVehicleSelection()
    {
		$vehicle1 = $this->createMMY('Honda','Civic','2000');
		$vehicle2 = $this->createMMY('Honda','Civic','2001');
		
		$product = $this->newWheelAdapterProduct();
        $product->setId(1);
        $product->addVafFit( $vehicle1->toValueArray() );
        
        $product->setWheelSideBoltPattern($this->boltPattern('4x114.3'));
        
        $params = $vehicle2->toValueArray() + array('wheel_lug_count'=>'4', 'wheel_stud_spread'=>'114.3');
        $this->setRequestParams($params);
        
        $flexibleSearch = $this->flexibleWheeladapterSearch($params);
        $this->assertEquals( array(0), $flexibleSearch->doGetProductIds(), 'should omit different vehicle selections (even if wheel side bolt matches)' );
    }
        
    function testClearingVehicleSelection()
    {
		return $this->markTestIncomplete();
		$vehicle = $this->createMMY();
		
		$product = $this->newWheelAdapterProduct();
        $product->setId(1);
        $product->addVafFit( $vehicle->toValueArray() );
        
        $product->setWheelSideBoltPattern($this->boltPattern('4x114.3'));
        
        $params = $vehicle->toValueArray() + array('wheel_lug_count'=>'4', 'wheel_stud_spread'=>'114.3');
        $this->setRequestParams($params);
        
        $flexibleSearch = $this->flexibleWheeladapterSearch($params);
        $this->assertEquals( array(1), $flexibleSearch->doGetProductIds() );
        
        $params = array('make'=>0,'model'=>0,'year'=>0) + array('wheel_lug_count'=>'4', 'wheel_stud_spread'=>'114.3');
        $this->setRequestParams($params);
        
//        debugbreak();
        $flexibleSearch = $this->flexibleWheeladapterSearch($params);
        $this->assertEquals( array(1), $flexibleSearch->doGetProductIds() );
    }
    
}