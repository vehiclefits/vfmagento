<?php
/**
* Vehicle Fits Free Edition - Copyright (c) 2008-2010 by Ne8, LLC
* PROFESSIONAL IDENTIFICATION:
* "www.vehiclefits.com"
* PROMOTIONAL SLOGAN FOR AUTHOR'S PROFESSIONAL PRACTICE:
* "Automotive Ecommerce Provided By Ne8 llc"
*
* All Rights Reserved
* VEHICLE FITS ATTRIBUTION ASSURANCE LICENSE (adapted from the original OSI license)
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the conditions in license.txt are met
*/
class Elite_Vafnote_Admin_VafnoteimportController extends Mage_Adminhtml_Controller_Action
{
    
    protected $block;
    
    function indexAction()
    {
        // magento boiler plate
        $this->loadLayout();
        $this->_setActiveMenu('vaf');
        $this->block = $this->getLayout()->createBlock('core/template' );
       	$this->block->setTemplate('vafnote/import.phtml');
       	
       	$this->guts();
       	
       	// magento boiler plate
        $this->_addContent( $this->block );
        $this->renderLayout();
    }
    
    function guts()
    {
		if( isset( $_FILES['file']['error'] ) && $_FILES['file']['error'] === 0 )
        {
			$importer = new Elite_Vafnote_Model_Import($_FILES['file']['tmp_name']);
            $importer->import();
            
            $this->block->messages = 'Done';
        }
    }
    
}