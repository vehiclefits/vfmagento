<?php
require_once('VafdefinitionsimporterController.php');
class Elite_Vafimporter_Admin_VafmappingsimporterController extends Elite_Vafimporter_Admin_VafdefinitionsimporterController
{ 
    /** @var Elite_Vafimporter_Model_ProductFitments */
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
        return new Elite_Vafimporter_Model_ProductFitments_CSV_Import( $_FILES['file']['tmp_name'] );
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