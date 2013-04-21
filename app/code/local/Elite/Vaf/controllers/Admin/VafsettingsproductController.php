<?php
class Elite_Vaf_Admin_VafsettingsproductController extends Mage_Adminhtml_Controller_Action
{ 
    function indexAction()
    {
        //$this->checkVersion();
        
        $this->loadLayout();
        $this->_setActiveMenu('vaf/import');
        
        $this->myIndexAction();
        
        $block = $this->getLayout()
                ->createBlock('core/template', 'vafsettings/product' )
                ->setTemplate('vf/vafsettings/product.phtml');
        
        $this->_addContent( $block );
        $this->renderLayout();
    }
    
    function myIndexAction()
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $form = new Elite_Vaf_Model_Settings_Product;
            $form->populate($_POST);
            
            $config = $form->getConfig();
            foreach($form->getElements() as $name=>$element)
            {
                if($name=='save') continue;
                $config->product->$name = $element->getValue();
            }
            
            $writer = new Zend_Config_Writer_Ini(array('config'   => $config,
                                                    'filename' => ELITE_CONFIG));
            echo $writer->write();
        }
    }
    
    
  
}