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
            $otherBlock->setTemplate('vf/vaf/group/result.phtml');
            return $otherBlock->_toHtml();
        }
        return parent::_toHtml();
    }

    function getTemplate()
    {
        if( $this->shouldShowSplash() )
        {
            $this->disableLayeredNavigation();
            return 'vf/vaf/splash.phtml';
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
        return !VF_Singleton::getInstance()->vehicleSelection()->isEmpty();
    }
    
    function setConfig($config)
    {
        $this->config = $config;
    }
    
    function getConfig()
    {
        if( !$this->config instanceof Zend_Config )
        {
            $this->config = VF_Singleton::getInstance()->getConfig();
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