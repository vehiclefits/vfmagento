<?php
class Elite_Vaf_Model_Catalog_Category_FilterImpl implements
    VF_Configurable,
    Elite_Vaf_Model_Catalog_Category_Filter
{
    /**
    * @var Zend_Config
    */
    protected $config;
    
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
    
    function isInWhiteList( $id )
    {
        return in_array( $id, $this->getWhiteList() );
    }
    
    function isInBlackList( $id )
    {
        return in_array( $id, $this->getBlackList() );
    }
    
    protected function getBlackList()
    {
        return explode( ",", $this->getConfig()->category->blacklist );
    }
    
    protected function getWhiteList()
    {
        if( null == $this->getConfig()->category->whitelist )
        {
            return array();
        }
        return explode( ",", $this->getConfig()->category->whitelist );
    }
    
    protected function hasWhiteList()
    {
        return count( $this->getWhiteList() );
    }
    
    /**
    * If whitelisting is ON, and category is in whitelist, will filter
    * if whitelisting is on, and category is not in whitelist, will not filter
    * 
    * If blacklist is specified and category is in blacklist, will not filter
    * 
    * If disable=true, will never filter on category page
    */
    function shouldShow( $categoryId )
    {
        if( !is_numeric( $categoryId) )
        {
            return true;
        }
        $show = true;
        if( $this->hasWhiteList() )
        {
            $show = $this->isInWhiteList( $categoryId ) ? true : false;
        }
        $show = $this->isInBlackList( $categoryId ) ? false : $show;
        $show = $this->getConfig()->category->disable ? false : $show;
        
        return $show;
    }
}