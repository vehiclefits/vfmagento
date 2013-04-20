<?php
/**
* Vehicle Fits Free Edition - Copyright (c) 2008-2010 by Vehicle Fits, LLC
* PROFESSIONAL IDENTIFICATION:
* "www.vehiclefits.com"
* PROMOTIONAL SLOGAN FOR AUTHOR'S PROFESSIONAL PRACTICE:
* "Automotive Ecommerce Provided By Vehicle Fits llc"
*
* All Rights Reserved
* VEHICLE FITS ATTRIBUTION ASSURANCE LICENSE (adapted from the original OSI license)
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the conditions in license.txt are met
*/
class Elite_Vaf_Block_Categories extends Elite_Vaf_Block_Abstract     
{
    /** @var array of category ids we are searching */
    protected $categories;       

  
    function getSearchPostUrl()
    {
        return $this->getUrl( 'vaf/results' );
    }
    
    function getCategories()
    {
        $helper = Mage::helper('catalog/category');
        $categories = $helper->getStoreCategories();
        return $categories;
    }
    
    function getCategoryUrl($category)
    {
        if ($category instanceof Mage_Catalog_Model_Category) {
            $url = $category->getUrl();
        } else {
            $url = $this->_getCategoryInstance()
                ->setData($category->getData())
                ->getUrl();
        }
        return $url;
    }
    
    protected function _getCategoryInstance()
    {
        if (is_null($this->_categoryInstance)) {
            $this->_categoryInstance = Mage::getModel('catalog/category');
        }
        return $this->_categoryInstance;
    }
    
    protected function isHomepage()
    {
        return $this->getRequest()->getRouteName() != 'catalog';
    }
    
}