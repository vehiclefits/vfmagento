<?php
require_once 'Mage/Catalog/controllers/ProductController.php';
class Elite_Vafsitemap_VehicleController extends Mage_Core_Controller_Front_Action
{
    /** Magento uses the "handle" of this action to load the block where the code lives */
    function indexAction()
    { 
        if( !Elite_Vaf_Helper_Data::getInstance()->getConfig()->seo->htmlSitemap )
        {
            return;
        }
        $this->loadLayout();
        $this->_initLayoutMessages('checkout/session');
        $this->_initLayoutMessages('tag/session');
        $this->renderLayout();
    }
}