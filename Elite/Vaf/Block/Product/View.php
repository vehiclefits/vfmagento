<?php
/**
* Vehicle Fits Free Edition - Copyright (c) 2008-2010 by Ne8, LLC
* PROFESSIONAL IDENTIFICATION:
* "www.vehiclefits.com"
* PROMOTIONAL SLOGAN FOR AUTHOR'S PROFESSIONAL PRACTICE:
* "Automotive Ecommerce Provided By Ne8 llc"
*
* All Rights Reserved
* VEHICLE FITS ATTRIBUTION ASSURANCE LICENSE (adapted from the original OSI license)
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the conditions in license.txt are met
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