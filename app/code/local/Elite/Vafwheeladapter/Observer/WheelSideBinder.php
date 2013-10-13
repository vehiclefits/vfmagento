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
class Elite_Vafwheeladapter_Observer_WheelSideBinder
{
	function bindWheelSide( $event )
	{
		$this->doBindWheelSide( $event->controller,  $event->product );
	}
	
	/**
    * @param Varien_Controller_Action
    * @param Mage_Catalog_Model_Product
    */
	function doBindWheelSide( $controller,  Elite_Vaf_Model_Catalog_Product $product )
	{
        $VFproduct = new VF_Product();
        $VFproduct->setId($product->getId());

		$wheeladapterProduct = new VF_Wheeladapter_Catalog_Product($VFproduct);
		$pattern = $controller->getRequest()->getParam( 'wheel_side_pattern' );
		if(!$pattern)
		{
			return $wheeladapterProduct->unsetWheelSideBoltPattern();
		}
		$boltPattern = VF_Wheel_BoltPattern::create( $pattern );
		$wheeladapterProduct->setWheelSideBoltPattern($boltPattern);
	}
}