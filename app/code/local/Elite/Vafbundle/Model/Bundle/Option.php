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
class Elite_Vafbundle_Model_Bundle_Option extends Mage_Bundle_Model_Option
{
    function getSelections()
    {
	$startTime = time();

        $vehicle = VF_Singleton::getInstance()->vehicleSelection();
        
        if( Mage::app()->getStore()->isAdmin() )
        {
            return $this->getData('selections');
        }

        if( !$this->superProductFits($vehicle) )
        {
            return $this->getData('selections');
        }
        
        $selections = $this->getData('selections');
        if( !$selections )
        {
			return;
        }
        
        if( $vehicle && $vehicle->getLeafValue() )
        {
	    $productIds = VF_Singleton::getInstance()->getProductIds();

	    $return = array();
            foreach( $selections as $product )
            {
                if(in_array($product->getId(),$productIds))
		{
		    array_push($return,$product);
		}
            }
            return $return;
        }

	$endTime = time();
	var_dump($endTime-$startTime); exit();
        return $selections;        
    }
    
    function productFits( $product, $vehicle )
    {
        $product->setCurrentlySelectedFit($vehicle);
        return $product->fitsSelection();
    }
    
    function superProductFits( $vehicle )
    {
        $superProduct = $this->superProduct();
        $superProduct->setCurrentlySelectedFit($vehicle);
        return $superProduct->fitsSelection();
    }
    
    function superProduct()
    {
        $superProductId = $this->getData('parent_id');
        $superProduct = new Elite_Vaf_Model_Catalog_Product();
        $superProduct->setId($superProductId);
        return $superProduct;
    }
}