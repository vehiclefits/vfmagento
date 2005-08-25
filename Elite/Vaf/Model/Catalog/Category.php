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
class Elite_Vaf_Model_Catalog_Category extends Mage_Catalog_Model_Category implements
    Elite_Vaf_Configurable,
    Elite_Vaf_Filterable
{
    // test only
    public $filtered;
    
    /**
    * @var Zend_Config
    */
    protected $config;
    
    /**
    * @var Elite_Vaf_Model_Catalog_Category_FilterImpl
    */
    protected $filter;
    
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
    
    function getFilter()
    {
        if( !$this->filter instanceof Elite_Vaf_Model_Catalog_Category_Filter )
        {
            $this->filter = new Elite_Vaf_Model_Catalog_Category_FilterImpl();
            $this->filter->setConfig( $this->getConfig() );
        }    
        return $this->filter;
    }
    
    function setFilter( Elite_Vaf_Model_Catalog_Category_Filter $filter )
    {
        $this->filter = $filter;
    }

    /** @return Mage_Core_Model_Mysql4_Collection_Abstract */
    function getProductCollection()
    {
        $collection = parent::getProductCollection();
        if( $this->shouldFilter() )
        { 
            $collection->addIdFilter( $this->getProductIdsInFilter() );
            $this->filtered = true; // test only
        }
        else
        {
            $this->filtered = false; // test only
        }
        
        return $collection;
    }
    
    protected function shouldFilter()
    {
        $filter = $this->getFilter()->shouldShow( $this->getId() );
        $filter = !$this->getProductIdsInFilter() ? false : $filter;
        return $filter;
    }
    
    protected function getProductIdsInFilter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getProductIds();
    }
    
}