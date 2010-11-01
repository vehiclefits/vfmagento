<?php
class Elite_Vafimporter_Adminhtml_Block_FitmentsAdvanced extends Mage_Adminhtml_Block_Widget
{
    protected $id;
    protected $entity;
    protected $messages = '';
    
    function __construct()
    {
        parent::__construct();
        
        $this->getConfig()->setFileField('file');
        
        if( isset( $_FILES['file']['error'] ) && $_FILES['file']['error'] === 0 )
        {
            $importer = new Elite_Vafimporter_Model_ProductFitments_Normalized( $_FILES['file']['tmp_name'] );
            $importer->import();
            $this->messages = number_format( $importer->getCountImported() ) . ' fit codes imported ';
            $this->messages .= '<br />' . number_format( $importer->getCountSkipped() ) . ' errors ';
            $this->messages .= '<br />' . implode( '<br />',  $importer->getErrors() ) . ' ';
        }  

        
        $this->setTemplate( 'vafimporter/Fitments_advanced.phtml' );
        $this->setId('vafimporter_Fitments'); 
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
