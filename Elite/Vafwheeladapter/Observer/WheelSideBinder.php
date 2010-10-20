<?php
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
		$wheeladapterProduct = new Elite_Vafwheeladapter_Model_Catalog_Product($product);
		$pattern = $controller->getRequest()->getParam( 'wheel_side_pattern' );
		if(!$pattern)
		{
			return $wheeladapterProduct->unsetWheelSideBoltPattern();
		}
		$boltPattern = Elite_Vafwheel_Model_BoltPattern::create( $pattern );
		$wheeladapterProduct->setWheelSideBoltPattern($boltPattern);
	}
}