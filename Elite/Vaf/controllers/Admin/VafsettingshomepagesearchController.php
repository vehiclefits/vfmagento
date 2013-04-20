<?php
class Elite_Vaf_Admin_VafsettingshomepagesearchController extends Mage_Adminhtml_Controller_Action
{ 
    function indexAction()
    {
        //$this->checkVersion();
        
        $this->loadLayout();
        $this->_setActiveMenu('vaf/import');
        
        $this->myIndexAction();
        
        $block = $this->getLayout()
                ->createBlock('core/template', 'vafsettings/homepagesearch' )
                ->setTemplate('vafsettings/homepagesearch.phtml');
        
        $this->_addContent( $block );
        $this->renderLayout();
    }
    
    function myIndexAction()
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $form = new Elite_Vaf_Model_Settings_Homepagesearch;
            $form->populate($_POST);
            
            $config = $form->getConfig();
            foreach($form->getElements() as $name=>$element)
            {
                if($name=='save') continue;
                $config->homepagesearch->$name = $element->getValue();
            }
            
            $writer = new Zend_Config_Writer_Ini(array('config'   => $config,
                                                    'filename' => ELITE_CONFIG));
            echo $writer->write();
        }
    }
    
    
  
}