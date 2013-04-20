<?php
class Elite_Vaftire_Observer_ProductTireSizeBinder
{
    protected $controller;
    
    function setTireSize( $event )
    {
        $this->controller = $event->controller;
        
        $tireProduct = $this->tireProduct($event->product);
        $this->doSetTireSize($tireProduct);
    }
    
    function doSetTireSize( Elite_Vaftire_Model_Catalog_Product $tireProduct )
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
        $tireSize = new Elite_Vaftire_Model_TireSize($sectionWidth,$aspectRatio,$diameter);
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
    
    function tireProduct($product)
    {
        return new Elite_Vaftire_Model_Catalog_Product($product);
    }
    
    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }
}