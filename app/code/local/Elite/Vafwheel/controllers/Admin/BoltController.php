<?php
class Elite_Vafwheel_Admin_BoltController extends Mage_Adminhtml_Controller_Action
{
    function boltpatternsAction()
    {
        $this->checkVersion();
        
        $this->loadLayout();
        $this->_setActiveMenu('vaf/boltpatterns');
        
        $block = $this->getLayout()->createBlock('adminhtml/vaf_boltpatterns', 'vaf/boltpatterns' );
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