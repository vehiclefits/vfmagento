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
            
            $this->config = VF_Singleton::getInstance()->getConfig();
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