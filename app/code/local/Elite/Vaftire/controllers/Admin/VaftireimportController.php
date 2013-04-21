<?php
/**
* Vehicle Fits Free Edition - Copyright (c) 2008-2010 by Vehicle Fits, LLC
* PROFESSIONAL IDENTIFICATION:
* "www.vehiclefits.com"
* PROMOTIONAL SLOGAN FOR AUTHOR'S PROFESSIONAL PRACTICE:
* "Automotive Ecommerce Provided By Vehicle Fits llc"
*
* All Rights Reserved
* VEHICLE FITS ATTRIBUTION ASSURANCE LICENSE (adapted from the original OSI license)
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the conditions in license.txt are met
*/
class Elite_Vaftire_Admin_VaftireimportController extends Mage_Adminhtml_Controller_Action
{
    function importAction()
    {
        $this->guts();
        
        // magento boiler plate
        $this->loadLayout();
        $this->_setActiveMenu('vaf');
        $block = $this->getLayout()->createBlock('core/template' );
       	$block->setTemplate( 'vf/vaftire/import.phtml');
        $this->_addContent( $block );
        $this->renderLayout();
    }
    
    function guts()
    {
		if( isset( $_FILES['file']['error'] ) && $_FILES['file']['error'] === 0 )
        {
			$importer = new Elite_Vaftire_Model_Catalog_Product_Import($_FILES['file']['tmp_name']);
            $importer->import();
        }
    }
    
}