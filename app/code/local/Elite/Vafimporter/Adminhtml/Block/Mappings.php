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
class Elite_Vafimporter_Adminhtml_Block_Mappings extends Elite_Vafimporter_Adminhtml_Block_Definitions_Import
{
    
    /** @var string Magento's unique block identifier for this block */
    protected $mageBlockId = 'vafimporter_mappings';
    
    /** @var string the name of the magento template to render with this block */
    protected $template = 'vf/vafimporter/mappings_import.phtml';
    
    /** @var VF_Import_ProductFitments */
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
