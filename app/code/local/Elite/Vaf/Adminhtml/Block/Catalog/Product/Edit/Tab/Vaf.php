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
class Elite_Vaf_Adminhtml_Block_Catalog_Product_Edit_Tab_Vaf extends Mage_Adminhtml_Block_Template 
    implements VF_Configurable
{
    protected $config;
    protected $schema;
    
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
            $this->config = VF_Singleton::getInstance()->getConfig();
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

    function setSchema($schema)
    {
        $this->schema = $schema;
    }

    function schema()
    {
        return $this->schema ? $this->schema : new VF_Schema;
    }
}
