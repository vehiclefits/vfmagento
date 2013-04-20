<?php
class Elite_Vaf_Admin_VafsettingscategoryController extends Mage_Adminhtml_Controller_Action
{ 
    function indexAction()
    {
        //$this->checkVersion();
        
        $this->loadLayout();
        $this->_setActiveMenu('vaf/import');
        
        $this->myIndexAction();
        
        $block = $this->getLayout()
                ->createBlock('core/template', 'vafsettings/category' )
                ->setTemplate('vafsettings/category.phtml');
        
        $this->_addContent( $block );
        $this->renderLayout();
    }
    
    function myIndexAction()
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $form = new Elite_Vaf_Model_Settings_Category;
            $form->populate($_POST);
            
            $config = $form->getConfig();
            $config->category->disable = $form->getValue('disable');
            $config->category->mode = $form->getValue('mode');
            $config->category->whitelist = $form->getValue('whitelist');
            $config->category->blacklist = $form->getValue('blacklist');
            $config->category->requireVehicle = $form->getValue('requireVehicle');
            
            
            $writer = new Zend_Config_Writer_Ini(array('config'   => $config,
                                                    'filename' => ELITE_CONFIG));
            echo $writer->write();
        }
    }
    
    
  
}