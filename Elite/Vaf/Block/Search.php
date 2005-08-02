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
class Elite_Vaf_Block_Search extends Elite_Vaf_Block_Abstract implements VF_Configurable
{
    public $searchStrategy;
    
    function __construct()
    {
        $this->searchStrategy = new VF_Search_Mage;
    }
    
    function __call($method, $arguments)
    {
        if(method_exists($this->searchStrategy,$method))
        {
            return call_user_func_array(array($this->searchStrategy,$method), $arguments);
        }
        else
        {
            return parent::__call($method, $arguments);
        }
    }
    
    function url( $route )
    {
        return Mage::getUrl( $route );
    }
    
    function _toHtml()
    {
        if( !$this->shouldShow( $this->currentCategoryId() ) )
        {
            return '';
        }
        $html = $this->renderView();
        return $html;
    }
    
    function setTemplate($template)
    {
        $this->searchStrategy->setTemplate($template);
        parent::setTemplate($template);
    }
    
    function setRequest($request)
    {
        $this->request = $request;
        $this->searchStrategy->setRequest($request);
    }
    
    function getRequest()
    {
        return $this->searchStrategy->getRequest();
    }
    
    function getConfig()
    {
        return $this->searchStrategy->getConfig();
    }

    function setConfig( Zend_Config $config )
    {
        $this->searchStrategy->setConfig($config);
    }
}

class VF_Search_Mage extends VF_Search
{
    /** @var array of category ids we are searching */
    protected $categories;
    
    /** @var Elite_Vaf_Block_Search_CategoryChooser */
    protected $chooser;
    
    /** @var Elite_Vaf_Model_Catalog_Category_Filter */
    protected $filter;
    
    protected $current_category_id;
    
    function __construct()
    {
         $this->categories = ( isset( $_GET['category'] ) && is_array( $_GET['category'] ) ) ? $_GET['category'] : array( 3 );
         foreach( $this->categories as $index => $id )
         {
             $this->categories[ $index ] = (int)$id; // allow integers only
         }
         $this->chooser = new Elite_Vaf_Block_Search_CategoryChooser();
    }
    
    function translate($text)
    {
        return Elite_Vaf_Helper_Data::getInstance()->__($text);
    }
    
    function currentCategoryId()
    {
        if(!$this->isCategoryPage())
        {
            return 0;
        }
        if(isset($this->current_category_id))
        {
            return $this->current_category_id;
        }
        $category = Mage::registry('current_category');
        $categoryId = is_object($category) ? $category->getId() : 0;
        $this->setCurrentCategoryId($categoryId);
        return $categoryId;
    }
    
    /**
     * Retrieve request object
     *
     * @return Mage_Core_Controller_Request_Http
     */
    function getRequest()
    {
        if( $this->_request instanceof Zend_Controller_Request_Abstract || $this->_request instanceof Mage_Core_Controller_Request_Http )
        {
            return $this->_request;
        }
        $this->_request = Elite_Vaf_Helper_Data::getInstance()->getRequest();
        return $this->_request;
    }
}