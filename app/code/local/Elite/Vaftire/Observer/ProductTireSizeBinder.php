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
class Elite_Vaftire_Observer_ProductTireSizeBinder
{
    protected $controller;
    
    function setTireSize( $event )
    {
        $this->controller = $event->controller;
        
        $tireProduct = $this->tireProduct($event->product);
        $this->doSetTireSize($tireProduct);
    }
    
    function doSetTireSize( VF_Tire_Catalog_TireProduct $tireProduct )
    {
        $tireProduct->setTireSize($this->tireSize());
        $tireProduct->setTireType($this->tireType());
    }
    
    function tireSize()
    {
        $sectionWidth = $this->getParam('section_width');
        $aspectRatio = $this->getParam('aspect_ratio');
        $diameter = $this->getParam('diameter');
        if( !$sectionWidth || !$aspectRatio || !$diameter )
        {
            return false;
        }
        $tireSize = new VF_TireSize($sectionWidth,$aspectRatio,$diameter);
        return $tireSize;
    }
    
    function getParam($param)
    {
        return $this->controller->getRequest()->getParam($param);
    }
    
    function tireType()
    {
		return $this->controller->getRequest()->getParam('tire_type');
    }

    /**
     * @param Mage_Catalog_Model_Product
     * @return VF_Tire_Catalog_TireProduct
     */
    function tireProduct($product)
    {
        $vfProduct = new VF_product();
        $vfProduct->setId($product->getId());
        return new VF_Tire_Catalog_TireProduct($vfProduct);
    }
    
    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return VF_Singleton::getInstance()->getReadAdapter();
    }
}