<?php
class Elite_Vafimporter_Admin_VafimporterController extends Mage_Adminhtml_Controller_Action
{ 

    function definitionsexportAction()
    {
    	$this->checkVersion();
        
        if( isset($_GET['go']) )
        {
            if( 'CSV' == $_REQUEST['format'])
            {
                header(sprintf('Content-Disposition: attachment;filename="vaf-export-%s.csv"',time()));
                header('Content-Type: text/csv');
            }
            else
            {
        	    header(sprintf('Content-Disposition: attachment;filename="vaf-export-%s.xml"',time()));
                header('Content-Type: text/xml');
            }

            if( 'CSV' == $_REQUEST['format'])
            {
			    $exporter = new Elite_Vafimporter_Model_VehiclesList_CSV_Export();
            }
            else
            {
                $exporter = new Elite_Vafimporter_Model_VehiclesList_XML_Export();
            }
			echo $exporter->export();
			
			exit();
        }
        
        $this->loadLayout();
        $this->_setActiveMenu('vaf/export');
        
        $block = $this->getLayout()->createBlock('core/template', 'vafimporter/definitionsexport' );
        $block->setTemplate( 'vafimporter/definitions_export.phtml' );
        $this->_addContent( $block );
        $this->renderLayout();
    }
    
    function FitmentsexportAction()
    {
    	$this->checkVersion();
        
        if( isset($_GET['go']) )
        {
        	header(sprintf('Content-Disposition: attachment;filename="vaf-export-%s.csv"',time()));
            header('Content-Type: text/csv');

			$exporter = new Elite_Vafimporter_Model_ProductFitments_CSV_Export();
			echo $exporter->export();
			
			exit();
        }
        
        $this->loadLayout();
        $this->_setActiveMenu('vaf/export');
        
        $block = $this->getLayout()->createBlock('core/template')->setTemplate('vafimporter/Fitments_export.phtml');
        $this->_addContent( $block );
        $this->renderLayout();
    }
    
    protected function checkVersion()
    {
        $version = new Elite_Vafinstall_Migrate;
        if( $version->needsUpgrade() )
        {
            echo 'Please run the upgrade-vaf.php script as per the documentation. Your database is out of date.';
            exit();
        }
    }

}