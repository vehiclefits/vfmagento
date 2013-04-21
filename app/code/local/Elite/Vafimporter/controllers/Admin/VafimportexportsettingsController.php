<?php
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