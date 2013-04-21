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
class Elite_Vafwheeladapter_Model_FlexibleSearch extends VF_FlexibleSearch_Wrapper implements VF_FlexibleSearch_Interface
{
    function doGetProductIds()
    {
        if( !$this->filteringOnWheelSide() && !$this->filteringOnVehicleSide() )
        {
            return $this->productIdsMatchingVehicleSelection();
        }
        
        $finder = new Elite_Vafwheeladapter_Model_Finder();
        if( $this->filteringOnWheelSide() && $this->filteringOnVehicleSide() )
        {
        	$productIds = $finder->getProductIds($this->wheelBolt(), $this->vehicleBolt());
		}
		else if ( !$this->filteringOnWheelSide() )
		{
			$productIds = $finder->getProductIds(null, $this->vehicleBolt());
		}
		else if ( !$this->filteringOnVehicleSide() )
		{
			$productIds = $finder->getProductIds($this->wheelBolt(), null);
			if( $this->wrappedFlexibleSearch->hasRequest() )
			{
				$productIds = array_intersect($productIds,$this->productIdsMatchingVehicleSelection());
			}
		}
		
        if( array() == $productIds )
        {
			return array(0);
        }
        return $productIds;
    }

    function productIdsMatchingVehicleSelection()
    {
		return $this->wrappedFlexibleSearch->doGetProductIds();
    }
    
    function filteringOnWheelSide()
    {
		return $this->wheelSideLugCount() && $this->wheelSideStudSpread();
    }
    
    function filteringOnVehicleSide()
    {
		return $this->vehicleSideLugCount() && $this->vehicleSideStudSpread();
    }
    
    function wheelBolt()
    {
		$wheelBoltString = $this->wheelSideLugCount() . 'x' . $this->wheelSideStudSpread();
        return Elite_Vafwheel_Model_BoltPattern::create( $wheelBoltString );
    }
    
    function vehicleBolt()
    {
		$vehicleBoltString = $this->vehicleSideLugCount() . 'x' . $this->vehicleSideStudSpread();
        return Elite_Vafwheel_Model_BoltPattern::create( $vehicleBoltString );
    }
    
    function storeAdapterSizeInSession()
    {
		if($this->shouldClear())
		{
			return $this->clear();
		}
		$_SESSION['wheel_lug_count'] = $this->getParam('wheel_lug_count');
		$_SESSION['wheel_stud_spread'] = $this->getParam('wheel_stud_spread');
		$_SESSION['vehicle_lug_count'] = $this->getParam('vehicle_lug_count');
		$_SESSION['vehicle_stud_spread'] = $this->getParam('vehicle_stud_spread');
    }
    
    function shouldClear()
    {
		return 0 == (int)$this->wheelSideLugCount() && 0 == (int)$this->wheelSideStudSpread() &&
			0 == (int)$this->vehicleSideLugCount() && 0 == (int)$this->vehicleSideStudSpread();
    }
    
    function clear()
    {
		unset( $_SESSION['wheel_lug_count'] );
		unset( $_SESSION['wheel_stud_spread'] );
		unset( $_SESSION['vehicle_lug_count'] );
		unset( $_SESSION['vehicle_stud_spread'] );
    }
    
    function wheelSideLugCount()
    {
		return $this->getParam('wheel_lug_count');
	}
    
    function wheelSideStudSpread()
    {
		return $this->getParam('wheel_stud_spread');
	}
	
	function vehicleSideLugCount()
    {
		return $this->getParam('vehicle_lug_count');
	}
	
	function vehicleSideStudSpread()
    {
		return $this->getParam('vehicle_stud_spread');
	}
    
}