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
require_once 'Mage/Catalog/controllers/ProductController.php';
class Elite_Vafsitemap_ProductController extends Mage_Core_Controller_Front_Action
{
    function indexAction()
    { 
        if( !Elite_Vaf_Singleton::getInstance()->getConfig()->seo->htmlSitemap )
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
        $block->setTemplate( 'vf/vafsitemap/product.phtml');
       // $block->setProductId( $this->getProductId() );
        $this->getLayout()->getBlock( 'content' )->append( $block );
        
        $this->renderLayout();
    }
}