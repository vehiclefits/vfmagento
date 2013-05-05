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

class Elite_Vafimporter_Admin_VafimporterController extends Mage_Adminhtml_Controller_Action
{

    function definitionsexportAction()
    {
	$this->checkVersion();

	if (isset($_GET['go']))
	{
	    if ('CSV' == $_REQUEST['format'])
	    {
		header(sprintf('Content-Disposition: attachment;filename="vaf-export-%s.csv"', time()));
		header('Content-Type: text/csv');
	    } else
	    {
		header(sprintf('Content-Disposition: attachment;filename="vaf-export-%s.xml"', time()));
		header('Content-Type: text/xml');
	    }

	    if ('CSV' == $_REQUEST['format'])
	    {
		$stream = fopen("php://output", 'w');
		$exporter = new VF_Import_VehiclesList_CSV_Export();
		$exporter->export($stream);
	    } else
	    {
		$exporter = new VF_Import_VehiclesList_XML_Export();
		echo $exporter->export();
	    }

	    exit();
	}

	$this->loadLayout();
	$this->_setActiveMenu('vaf/export');

	$block = $this->getLayout()->createBlock('core/template', 'vafimporter/definitionsexport');
	$block->setTemplate( 'vf/vafimporter/definitions_export.phtml');
	$this->_addContent($block);
	$this->renderLayout();
    }

    function mappingsexportAction()
    {
	$this->checkVersion();

	if (isset($_GET['go']))
	{
	    header(sprintf('Content-Disposition: attachment;filename="vaf-export-%s.csv"', time()));
	    header('Content-Type: text/csv');

	    $stream = fopen("php://output", 'w');
	    $exporter = new VF_Import_ProductFitments_CSV_Export();
	    $exporter->export($stream);

	    exit();
	}

	$this->loadLayout();
	$this->_setActiveMenu('vaf/export');

	$block = $this->getLayout()->createBlock('core/template')->setTemplate( 'vf/vafimporter/mappings_export.phtml');
	$this->_addContent($block);
	$this->renderLayout();
    }

    protected function checkVersion()
    {
	$version = new Elite_Vafinstall_Migrate;
	if ($version->needsUpgrade())
	{
	    echo 'Please run the upgrade-vaf.php script as per the documentation. Your database is out of date.';
	    exit();
	}
    }

}