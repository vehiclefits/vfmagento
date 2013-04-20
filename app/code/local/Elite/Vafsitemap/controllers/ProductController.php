<?php
require_once 'Mage/Catalog/controllers/ProductController.php';
class Elite_Vafsitemap_ProductController extends Mage_Core_Controller_Front_Action
{
    function indexAction()
    { 
        if( !Elite_Vaf_Helper_Data::getInstance()->getConfig()->seo->htmlSitemap )
        {
            return;
        }
        $this->loadLayoutAndBlock();
    }
    
    /** Magento Boilerplate */
    protected function loadLayoutAndBlock()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('checkout/session');
        $this->_initLayoutMessages('tag/session');
        
        $block = $this->getLayout()->createBlock( 'vafsitemap/product', 'vafsitemap_products' );
        $block->setTemplate('vafsitemap/product.phtml');
       // $block->setProductId( $this->getProductId() );
        $this->getLayout()->getBlock( 'content' )->append( $block );
        
        $this->renderLayout();
    }
}