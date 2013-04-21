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
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

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