<?php
/**
* Vehicle Fits Free Edition - Copyright (c) 2008-2010 by Ne8, LLC
* PROFESSIONAL IDENTIFICATION:
* "www.vehiclefits.com"
* PROMOTIONAL SLOGAN FOR AUTHOR'S PROFESSIONAL PRACTICE:
* "Automotive Ecommerce Provided By Ne8 llc"
*
* All Rights Reserved
* VEHICLE FITS ATTRIBUTION ASSURANCE LICENSE (adapted from the original OSI license)
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the conditions in license.txt are met
*/
require_once 'Mage/Catalog/controllers/ProductController.php';
class Elite_Vaf_ProductController extends Mage_Catalog_ProductController
{
    function listAction()
    { 
        $helper = Elite_Vaf_Helper_Data::getInstance();
        
        $helper->setRequest( $this->getRequest() );
        $helper->storeFitInSession();
        
        if(!$helper->getFit() || !$helper->getProductIds() )
        {
            return $this->redirectToHomePage();
        }
        
        
        $this->myLoadLayout();
        switch( Elite_Vaf_Helper_Data::getInstance()->getConfig()->homepagesearch->mode )
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