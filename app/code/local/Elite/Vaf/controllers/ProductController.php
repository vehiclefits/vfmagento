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
class Elite_Vaf_ProductController extends Mage_Catalog_ProductController
{
    function listAction()
    { 
        $helper = VF_Singleton::getInstance();
        
        $helper->setRequest( $this->getRequest() );
        $helper->storeFitInSession();
        
        if(!$helper->vehicleSelection() || !$helper->getProductIds() )
        {
            return $this->redirectToHomePage();
        }
        
        
        $this->myLoadLayout();
        switch( VF_Singleton::getInstance()->getConfig()->homepagesearch->mode )
        {
            case 'grid':
                // set in layout.xml
            break;
            default:
            case 'group':
                // unset the grid block added from layout.xml
                $this->getLayout()->getBlock('content')->unsetChild('vaf_products');
                
                $block = $this->createBlock( 'vaf/product_result_group', 'vaf_products' );
                $this->appendBlock($block);
            break;
            case 'category':
                // unset the grid block added from layout.xml
                $this->getLayout()->getBlock('content')->unsetChild('vaf_products');
                
                $block = $this->createBlock( 'vaf/product_result_group2', 'vaf_products' );
                $this->appendBlock($block);
            break;
            case 'group3':
                // unset the grid block added from layout.xml
                $this->getLayout()->getBlock('content')->unsetChild('vaf_products');
                
                $block = $this->createBlock( 'vaf/product_result_group3', 'vaf_products' );
                $this->appendBlock($block);
            break;
        }

        $this->renderLayout();
    }
    
    function redirectToHomePage()
    {
        $baseUrl = Mage::getBaseUrl();
        $this->getResponse()->setRedirect( $baseUrl );    
    }
    
    /** Magento Wrapper */
    function myLoadLayout()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('checkout/session');
        $this->_initLayoutMessages('tag/session');
    }
    
    /** Magento Wrapper */
    function createBlock($type,$name,$attribs=array())
    {
        return $this->getLayout()->createBlock($type,$name,$attribs);
    }
    
    /** Magento Wrapper */
    function appendBlock($block)
    {
        $this->getLayout()->getBlock( 'content' )->append( $block );
    }
}