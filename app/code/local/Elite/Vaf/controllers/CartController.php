<?php                           
/**
* Vehicle Fits Free Edition - Copyright (c) 2008-2010 by Vehicle Fits, LLC
* PROFESSIONAL IDENTIFICATION:
* "www.vehiclefits.com"
* PROMOTIONAL SLOGAN FOR AUTHOR'S PROFESSIONAL PRACTICE:
* "Automotive Ecommerce Provided By Vehicle Fits llc"
*
* All Rights Reserved
* VEHICLE FITS ATTRIBUTION ASSURANCE LICENSE (adapted from the original OSI license)
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the conditions in license.txt are met
*/
require_once( 'Mage/Checkout/controllers/CartController.php' );
class Elite_Vaf_CartController extends Mage_Checkout_CartController
{    
    protected $product;
    protected $config;
    
    /** Adding products to cart */
    function addAction()
    {
        if( $this->shouldShowIntermediatePage() )
        {
            $url = $this->getChooseVehicleUrl( $this->getProductId() );
            return $this->getResponse()->setRedirect( $url );
        }
        return parent::addAction();
    }
    
    /** Intermediate Vehicle Selection Page Prior to adding to cart */
    function choosevehicleAction()
    {
        if( $this->customerAlreadySelectedFit() )
        {
            $ids = Elite_Vaf_Helper_Data::getInstance()->getProductIds();
            $product = $this->getRequest()->getParam( 'product' );
            if( in_array( $product, $ids ) )
            {
                return $this->addAction();
            }
            throw new Exception( 'Trying to add a product to cart with invalid vehicle selection' );
        }
        $this->mageChooseVehicle();
    }
    
    function shouldShowIntermediatePage()
    {
        if( !$this->getConfig()->product->requireVehicleBeforeCart || $this->getConfig()->product->requireVehicleBeforeCart == 'false' )
        {
            return false;
        }
        
        if( !count( $this->getProduct()->getFits() ) )
        {
            return false;
        }
        
        return !$this->customerAlreadySelectedFit();
    }
    
    /**
    * Magento Boilerplate
    * @return Elite_Vaf_Model_Catalog_Product
    */
    protected function getProduct()
    {
        if(isset($this->product))
        {
            return $this->product;
        }
        $product = Mage::getModel( 'catalog/product' )->load( $this->getProductId() );
        $this->product = $product;
        return $product;
    }
    
    function setProduct($product)
    {
        $this->product = $product;
    }
    
    protected function getChooseVehicleUrl( $productid )
    {
        return Mage::getUrl("*/*/choosevehicle/product/$productid") . '?' . http_build_query( $_POST );
    }
    
    protected function customerAlreadySelectedFit()
    {
        return !Elite_Vaf_Helper_Data::getInstance()->vehicleSelection()->isEmpty();
    }
    
    protected function getProductId()
    {
        return (int) $this->getRequest()->getParam('product');
    }
    
    /** Magento Boilerplate */
    protected function mageChooseVehicle()
    {
        $this->myLoadLayout();
        
        $block = $this->createBlock( 'vaf/search_choosevehicle', 'vaf.choosevehicle' );
        $block->setProductId( $this->getProductId() );
        
        $this->appendBlock($block);
        $this->renderLayout();
    }
    
    /** Magento Wrapper */
    function myLoadLayout()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('checkout/session');
        $this->_initLayoutMessages('tag/session');
    }
    
    /** Magento Wrapper */
    function createBlock($type,$name)
    {
        return $this->getLayout()->createBlock($type,$name);
    }
    
    /** Magento Wrapper */
    function appendBlock($block)
    {
        $this->getLayout()->getBlock( 'content' )->append( $block );
    }
    
    function setConfig($config)
    {
        $this->config = $config;
    }
    
    function getConfig()
    {
        if( !$this->config instanceof Zend_Config )
        {
            $this->config = Elite_Vaf_Helper_Data::getInstance()->getConfig();
        }    
        return $this->config;
    }
}