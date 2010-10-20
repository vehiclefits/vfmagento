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
class Elite_Vaftire_Admin_VaftirevehicleimportController extends Mage_Adminhtml_Controller_Action
{
    function importAction()
    {
        $this->guts();
        
        // magento boiler plate
        $this->loadLayout();
        $this->_setActiveMenu('vaf');
        $block = $this->getLayout()->createBlock('core/template' );
       	$block->setTemplate('vaftire/vehicle/import.phtml');
        $this->_addContent( $block );
        $this->renderLayout();
    }
    
    function guts()
    {
		if( isset( $_FILES['file']['error'] ) && $_FILES['file']['error'] === 0 )
        {
			$importer = new Elite_Vaftire_Model_Importer_Definitions_TireSize($_FILES['file']['tmp_name']);
            $importer->import();
        }
    }
    
}