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
class Elite_Vafnote_Admin_VafnotemanageController extends Mage_Adminhtml_Controller_Action
{
    function indexAction()
    {
        $finder = new Elite_Vafnote_Model_Finder();
        
        if( isset( $_GET['code'] ) && isset($_GET['message']) )
        {
            $finder->insert( $_GET['code'], $_GET['message'] );
        }
        
        $this->loadLayout();
        $this->_setActiveMenu('vaf');
        
        $block = $this->getLayout()->createBlock('adminhtml/manage', 'vafnote' );
        
        if( $this->getRequest()->getParam('delete') )
        {
            if( $this->getRequest()->getParam('confirm') )
            {
                $finder->delete($this->getRequest()->getParam('id'));
                $block->setTemplate('vafnote/manage.phtml');
            }
            else
            {
                $block->setTemplate('vafnote/delete.phtml');
            }
        }
        else
        {
            $block->setTemplate('vafnote/manage.phtml');
        }
        
        $this->_addContent( $block );
        $this->renderLayout();
    }
    
    function editAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('vaf');
        
        if( $this->getRequest()->getParam('message') )
        {
            $finder = new Elite_Vafnote_Model_Finder;
            $id = $this->getRequest()->getParam('id');
            $message = $this->getRequest()->getParam('message');
            $finder->update( $id, $message );
            
            $block = $this->getLayout()->createBlock('adminhtml/manage', 'vafnote' );
            $block->setTemplate('vafnote/manage.phtml');
            $this->_addContent( $block );
        	$this->renderLayout();
        	return;
        }
        
        $block = $this->getLayout()->createBlock('adminhtml/edit', 'vafnote' );
        $block->id = $this->getRequest()->getParam('id');
        $block->setTemplate('vafnote/edit.phtml');
        $this->_addContent( $block );
        
        $this->renderLayout();  
    }
}