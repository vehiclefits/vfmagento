<?php
class Elite_Vafimporter_Adminhtml_Block_Mappings extends Elite_Vafimporter_Adminhtml_Block_Definitions_Import
{
    
    /** @var string Magento's unique block identifier for this block */
    protected $mageBlockId = 'vafimporter_mappings';
    
    /** @var string the name of the magento template to render with this block */
    protected $template = 'vafimporter/mappings_import.phtml';
    
    /** @var Elite_Vafimporter_Model_ProductFitments */
    protected $importer;
  
    /** @return Varien_Config */
    function getConfig()
    {
        if(is_null($this->_config)) {
            $this->_config = new Varien_Object();
        }

        return $this->_config;
    }
    
    protected function getSaveUrl()
    {
        $url = Mage::helper('adminhtml')->getUrl('*/*/*', array(
            '_current'=>true, 'back'=>null
        ));
        return $url;
    }
}
