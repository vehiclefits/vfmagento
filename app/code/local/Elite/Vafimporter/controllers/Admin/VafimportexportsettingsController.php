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
class Elite_Vafimporter_Admin_VafimportexportsettingsController extends Mage_Adminhtml_Controller_Action
{ 
    function indexAction()
    {
        //$this->checkVersion();
        
        $this->loadLayout();
        $this->_setActiveMenu('vaf/import');
        
        $this->myIndexAction();
        
        $block = $this->getLayout()
                ->createBlock('core/template', 'vafimporter/settings' )
                ->setTemplate( 'vf/vafimporter/settings.phtml');
        
        $this->_addContent( $block );
        $this->renderLayout();
    }
    
    function myIndexAction()
    {
        if($_SERVER['REQUEST_METHOD'])
        {
            $form = new VF_Import_Settings;
            $form->populate($_POST);
            
            $config = $form->getConfig();
            $config->importer->allowMissingFields = $form->getValue('allowMissingFields');
            $config->importer->Y2KMode = $form->getValue('Y2KMode');
            $config->importer->Y2KThreshold = $form->getValue('Y2KThreshold');
            
            $writer = new Zend_Config_Writer_Ini(array('config'   => $config,
                                                    'filename' => ELITE_CONFIG));
            echo $writer->write();
        }
    }
    
    
  
}