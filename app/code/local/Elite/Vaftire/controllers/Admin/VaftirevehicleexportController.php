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
class Elite_Vaftire_Admin_VaftirevehicleexportController extends Mage_Adminhtml_Controller_Action
{

    function exportAction()
    {
	$this->guts();

	// magento boiler plate
	$this->loadLayout();
	$this->_setActiveMenu('vaf');
	$block = $this->getLayout()->createBlock('core/template');
	$block->setTemplate( 'vf/vaftire/export.phtml');
	$this->_addContent($block);
	$this->renderLayout();
    }

    function guts()
    {
	if (isset($_GET['go']))
	{
	    header(sprintf('Content-Disposition: attachment;filename="vaf-export-%s.csv"', time()));
	    header('Content-Type: text/csv');

	    $exporter = new Elite_Vaftire_Model_Catalog_Product_Export($_FILES['file']['tmp_name']);
	    echo $exporter->export();
	    exit();
	}
    }

}