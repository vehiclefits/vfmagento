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
require_once('VafdefinitionsimporterController.php');
class Elite_Vafimporter_Admin_VafmappingsimporterController extends Elite_Vafimporter_Admin_VafdefinitionsimporterController
{ 
    /** @var VF_Import_ProductFitments */
    protected $importer;
    
    function indexAction()
    {
        $this->checkVersion();
        
        $this->loadLayout();
        $this->_setActiveMenu('vaf/import');
        
        $this->myIndexAction();
        
        $block = $this->getLayout()->createBlock('adminhtml/vafimporter_mappings', 'vafimporter/mappings' );
        $block->messages = $this->messages;
        
        $this->_addContent( $block );
        $this->renderLayout();
    }
    
    function importer()
    {
        return new VF_Import_ProductFitments_CSV_Import( $_FILES['file']['tmp_name'] );
    }
    
    protected function doFormatMessages()
    {
        $this->formatMessage( '<strong>Product Fitments Import Results</strong>' );
        $this->formatMessage( number_format( $this->importer->getCountMappings() ) . ' fitments discovered' );
        if( count($this->importer->nonExistantSkus()) )
        {
            $exampleSKUs = array_chunk($this->importer->nonExistantSkus(), 10);
            $this->formatMessage( number_format($this->importer->rowsWithNonExistantSkus()) . ' rows generated ' . number_format( $this->importer->nonExistantSkusCount() ) . ' Invalid SKU errors. ' . count($this->importer->nonExistantSkus()) . ' SKUs invalid or not found. Examples:' . implode(',', $exampleSKUs[0]) );
        }
        
        if( $this->importer->getCountSkippedMappings() > 0)
        {   
            $this->formatMessage( number_format( $this->importer->getCountSkippedMappings() ) . ' fitments skipped because they are already "known about"' );
        }
        
        if($this->importer->invalidVehicleCount() > 0)
        {
            $this->formatMessage( number_format( $this->importer->invalidVehicleCount() ) . ' fitments skipped because the vehicle part is invalid or blank' );
        }
    }
  
}