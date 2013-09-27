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

class Elite_Vaf_Model_Catalog_Category extends Mage_Catalog_Model_Category implements
    VF_Configurable
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
            $this->config = Elite_Vaf_Singleton::getInstance()->getConfig();
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
        return Elite_Vaf_Singleton::getInstance()->getProductIds();
    }
    
}