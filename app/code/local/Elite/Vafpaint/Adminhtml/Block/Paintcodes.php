<?php
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