<?php
class Elite_Vaf_Adminhtml_Block_Catalog_Product_Edit_Tab_Vaf extends Mage_Adminhtml_Block_Template 
    implements VF_Configurable
{
    protected $config;
    
    function __construct()
    {
        parent::__construct();
        $this->setTemplate('vf/catalog/product/tab/vaf.phtml');
    }           
    
    function getFits()
    {
         return $this->getProduct()->getFits();
    }
    
    function getProduct()
    {
        $product = Mage::registry('product');
        return $product;
    }
    
    function renderConfigurations()
    {
        $return = '';
        if( file_exists(ELITE_PATH.'/Vafwheel') )
        {
            $this->setScriptPath($this->designScriptPath());
            $html = $this->fetchView($this->myGetTemplateFile('vf/catalog/product/tab/vaf-wheel.phtml'));
            $return .= $html;
        }
        if( file_exists(ELITE_PATH.'/Vafwheeladapter') )
        {
            $this->setScriptPath($this->designScriptPath());
            $html = $this->fetchView($this->myGetTemplateFile('vf/catalog/product/tab/vaf-wheeladapter.phtml'));
            $return .= $html;
        }
        if( file_exists(ELITE_PATH.'/Vaftire') )
        {
            $this->setScriptPath($this->designScriptPath());
            $html = $this->fetchView($this->myGetTemplateFile('vf/catalog/product/tab/vaf-tire.phtml'));
            $return .= $html;
        }
        return $return;
    }
    
    function designScriptPath()
    {
        return Mage::getBaseDir('design');
    }
    
    function myGetTemplateFile($file)
    {
        $params = array('_relative'=>true);
        $area = $this->getArea();
        if ($area) {
            $params['_area'] = $area;
        }
        $templateName = Mage::getDesign()->getTemplateFilename($file, $params);
        return $templateName;
    }
    
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
    
    function unavailableSelections()
    {
        return $this->getConfig()->search->unavailableSelections;
    }
}
