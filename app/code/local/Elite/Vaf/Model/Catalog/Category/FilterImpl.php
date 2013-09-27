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
            
            $this->config = VF_Singleton::getInstance()->getConfig();
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