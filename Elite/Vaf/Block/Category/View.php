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
class Elite_Vaf_Block_Category_View extends Mage_Catalog_Block_Category_View
{
    protected $config;
    protected $categoryId;

    protected function _toHtml()
    {
        if($this->shouldShowSplash())
        {
            return parent::_toHtml();
        }
        if($this->getConfig()->category->mode == 'group')
        {
            $otherBlock = new Elite_Vaf_Block_Product_Result_Group;
            $otherBlock->setLayout($this->getLayout());
            $otherBlock->setTemplate('vaf/group/result.phtml');
            return $otherBlock->_toHtml();
        }
        return parent::_toHtml();
    }

    function getTemplate()
    {
        if( $this->shouldShowSplash() )
        {
            $this->disableLayeredNavigation();
            return 'vaf/splash.phtml';
        }
//        if($this->getConfig()->category->mode == 'group')
//        {
//            return 'vaf/group/result.phtml';
//        }
        return parent::getTemplate();
    }
    
    function disableLayeredNavigation()
    {
        $layeredNav = $this->getLayout()->getBlock('catalog.leftnav');
        $layeredNav->setTemplate(false);
    }
    
    /** @return boolean */
    function shouldShowSplash()
    {
        if($this->vehicleIsSelected())
        {
            return false;
        }
        
        if($this->isWildcard())
        {
            return true;
        }
        if( in_array($this->getCategoryId(), $this->categoryIdsThatRequireVehicleSelection() ) )
        {
            return true;
        }
        return false;
    }
    
    /** @return array of category IDs */
    function categoryIdsThatRequireVehicleSelection()
    {
        $ids = trim($this->getConfig()->category->requireVehicle);
        $ids = explode(",",$ids);
        return $ids;
    }

    function isWildcard()
    {
        return $this->getConfig()->category->requireVehicle == 'all';
    }
    
    /** @return boolean */
    function vehicleIsSelected()
    {
        return !Elite_Vaf_Helper_Data::getInstance()->vehicleSelection()->isEmpty();
    }
    
    function setConfig($config)
    {
        $this->config = $config;
    }
    
    function getConfig()
    {
        if( !$this->config instanceof Zend_Config )
        {
            $this->config = Elite_Vaf_Helper_Data::getInstance()->getConfig();
        }    
        return $this->config;
    }
    
    function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }
    
    function getCategoryId()
    {
        if(!$this->categoryId)
        {
            return $this->getCurrentCategory()->getId();
        }
        return $this->categoryId;
    }
    

}