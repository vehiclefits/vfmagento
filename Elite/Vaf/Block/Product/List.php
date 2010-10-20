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
class Elite_Vaf_Block_Product_List extends Mage_Catalog_Block_Product_List
{
    function getLoadedProductCollection()
    {
        $collection = $this->_getProductCollection();
        $filter = new Elite_Vaf_Model_Catalog_Category_FilterImpl();
        $category = Mage::registry('current_category');
        if( !is_object($category ) )
        {
            return $collection;
        }
        $category_id = $category->getId();
        if( $filter->shouldShow( $category_id ) )
        {
            $this->applyNames( $collection );
        }
        return $collection;
    }
    
    /** @todo write acceptance test 0000328: Elite_Vaf_Block_Product_List should not depend on SEO module being present */
    protected function applyNames( $collection )
    {
        if( class_exists( 'Elite_Vafsitemap_Helper_SeoName', false ) )
        {
            $helper = new Elite_Vafsitemap_Helper_SeoName();
            foreach( $collection as $product )
            {
                $helper->applyName( $product );
            }
        }
    }
       
}