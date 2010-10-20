<?php
class Elite_Vafimporter_Adminhtml_Block_Definitions_Import extends Mage_Adminhtml_Block_Widget
{
    /** @var string Magento's unique block identifier for this block */
    protected $mageBlockId = 'vafimporter_definitions_import';
    
    /** @var string the name of the magento template to render with this block */
    protected $template = 'vafimporter/definitions_import.phtml';
    
    public $messages;
    
    function __construct()
    {
        parent::__construct();
        
		$this->setTemplate( $this->template );
        $this->setId( $this->mageBlockId ); 
    }
}