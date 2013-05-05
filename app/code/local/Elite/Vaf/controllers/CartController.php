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
            $ids = VF_Singleton::getInstance()->getProductIds();
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
        return !VF_Singleton::getInstance()->vehicleSelection()->isEmpty();
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
            $this->config = VF_Singleton::getInstance()->getConfig();
        }    
        return $this->config;
    }
}