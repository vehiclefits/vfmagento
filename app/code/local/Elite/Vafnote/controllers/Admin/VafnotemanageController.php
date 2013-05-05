<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to sales@vehiclefits.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Elite_Vafnote_Admin_VafnotemanageController extends Mage_Adminhtml_Controller_Action
{
    function indexAction()
    {
        $finder = new VF_Note_Finder();
        
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
                $block->setTemplate( 'vf/vafnote/manage.phtml');
            }
            else
            {
                $block->setTemplate( 'vf/vafnote/delete.phtml');
            }
        }
        else
        {
            $block->setTemplate( 'vf/vafnote/manage.phtml');
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
            $finder = new VF_Note_Finder;
            $id = $this->getRequest()->getParam('id');
            $message = $this->getRequest()->getParam('message');
            $finder->update( $id, $message );
            
            $block = $this->getLayout()->createBlock('adminhtml/manage', 'vafnote' );
            $block->setTemplate( 'vf/vafnote/manage.phtml');
            $this->_addContent( $block );
        	$this->renderLayout();
        	return;
        }
        
        $block = $this->getLayout()->createBlock('adminhtml/edit', 'vafnote' );
        $block->id = $this->getRequest()->getParam('id');
        $block->setTemplate( 'vf/vafnote/edit.phtml');
        $this->_addContent( $block );
        
        $this->renderLayout();  
    }
}