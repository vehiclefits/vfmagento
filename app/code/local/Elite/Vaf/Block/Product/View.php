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

class Elite_Vaf_Block_Product_View extends Mage_Catalog_Block_Product_View
{
    /** @return Mage_Catalog_Model_Product */
    function getProduct()
    {
        $product = parent::getProduct();
        $this->applyName( $product );
        return $product;
    }
    
    protected function applyName( $product )
    {
        if( $this->shouldApplyName( $product ) )
        {
            if( file_exists(ELITE_PATH.'/Vafsitemap') )
        	{
                $helper = new Elite_Vafsitemap_Helper_SeoName();
                $helper->applyName( $product );
            }
        }
    }
    
    /** @param Elite_Vaf_Catalog_Model_Product */
    protected function shouldApplyName( $product )
    {
        $filter = new Elite_Vaf_Model_Catalog_Category_FilterImpl;
        return $product->isInEnabledCategory( $filter );
    }
    
}