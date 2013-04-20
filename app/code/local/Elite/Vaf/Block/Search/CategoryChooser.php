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
class Elite_Vaf_Block_Search_CategoryChooser implements VF_Configurable
{
    /** @var Zend_Config */
    protected $config;

    /**
    * A crutch for Magento
    * @todo refactor this out of here into an adapter
    */    
    protected $_categoryInstance;
    
    function getConfig()
    {
        if( !$this->config instanceof Zend_Config )
        {
            
            $this->config = Elite_Vaf_Helper_Data::getInstance()->getConfig();
        }    
        return $this->config;
    }
    
    function setConfig( Zend_Config $config )
    {
        $this->config = $config;
    }
    
    function showCategoryChooserHomepage()
    {
        if( $this->getConfig()->categorychooser->onHomepage )
        {
            return true;
        }
        if( $this->getConfig()->categorychooser->onAllPages && !isset( $this->getConfig()->categorychooser->onHomepage ) )
        {
            return true;
        }
        return false;
    }
    
    function showCategoryChooserNonHomepage()
    {
        if( $this->getConfig()->categorychooser->onAllPages )
        {
            return true;
        }        
        return false;
    }
    
    /** @return bool */
    function showAllOptionHomepage()
    {
        if( $this->getConfig()->categorychooser->allOptionOnHomepage  )
        {
            return true;
        }
        if( $this->getConfig()->categorychooser->allOptionOnAllPages && !isset( $this->getConfig()->categorychooser->allOptionOnHomepage ) )
        {
            return true;
        }
        return false;
    }
    
    /** @return bool */
    function showAllOptionAllPages()
    {
        if( $this->getConfig()->categorychooser->allOptionOnAllPages )
        {
            return true;
        }
        return false;
    }
    
    function getFilteredCategories( array $categories )
    {
        if( !$this->isIgnoringCategories() )
        {
            return $categories;
        }
        $return = array();
        foreach( $categories as $category )
        {
            if( $this->isIgnoringCategory( $category ) )
            {
                array_push( $return, $category );
            }
        }
        return $return;
    }
    
    function getAllCategories()
    {
        $helper = Mage::helper('catalog/category');
        $categories = $helper->getStoreCategories();
        $return = array();
        foreach( $categories as $category )
        {
            array_push( $return, $this->doCategory( $category ) );
        }
        return $return;
    }
    
    protected function doCategory( $category )
    {
        return array(
            'id' => $category->getId(),
            'url' => $this->getCategoryUrl( $category ),
            'title' => $category->getName()
        ); 
    }
    
    protected function isIgnoringCategories()
    {
        return isset( $this->getConfig()->categorychooser->ignore );
    }
    
    protected function isIgnoringCategory( $category )
    {
        return !in_array( $category['id'], explode( ',', $this->getConfig()->categorychooser->ignore ) );
    }
 
    /**
    * A crutch for Magento
    * @todo refactor this out of here into an adapter
    */
    private function getCategoryUrl($category)
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
    
    /**
    * A crutch for Magento
    * @todo refactor this out of here into an adapter
    */
    protected function _getCategoryInstance()
    {
        if (is_null($this->_categoryInstance)) {
            $this->_categoryInstance = Mage::getModel('catalog/category');
        }
        return $this->_categoryInstance;
    }
}