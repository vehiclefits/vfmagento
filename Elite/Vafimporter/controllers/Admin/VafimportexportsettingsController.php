<?php
class Elite_Vafimporter_Admin_VafimportexportsettingsController extends Mage_Adminhtml_Controller_Action
{ 
    function indexAction()
    {
        //$this->checkVersion();
        
        $this->loadLayout();
        $this->_setActiveMenu('vaf/import');
        
        //$this->myIndexAction();
        
        $block = $this->getLayout()->createBlock('adminhtml/vafimporter_settings', 'vafimporter/settings' );
        
        $this->_addContent( $block );
        $this->renderLayout();
    }
    
    
  
}