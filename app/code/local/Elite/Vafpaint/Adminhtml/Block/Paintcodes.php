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
class Elite_Vafpaint_Adminhtml_Block_Paintcodes extends Mage_Adminhtml_Block_Widget
{
    protected $id;
    protected $entity;
    protected $messages = '';
    
    function __construct()
    {
        parent::__construct();
        
        if( isset( $_FILES['file']['error'] ) && $_FILES['file']['error'] === 0 )
        {
            $importer = new Elite_Vafpaint_Model_Importer_Definitions_Paint( $_FILES['file']['tmp_name'] );
            $importer->import();
            $this->messages = 'Import Complete';
        }
        
        $this->setTemplate( 'vf/vaf/paintcodes.phtml' );
    }
  
    /**
     * Retrive config object
     *
     * @return Varien_Config
     */
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