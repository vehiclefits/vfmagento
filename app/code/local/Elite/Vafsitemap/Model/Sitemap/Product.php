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
abstract class Elite_Vafsitemap_Model_Sitemap_Product extends Elite_Vafsitemap_Model_Sitemap_Vehicle
{
	protected $storeId;
    
    function getItemUrl($product)
    {
        $rewrite = new Elite_Vafsitemap_Model_Url_Rewrite;
        $rewrite->setData( 'product_id', $product->getId() );
        $rewrite->setData( 'url_path', $product->getData( 'url_path' ) );
        return $rewrite->getRequestPathForDefinition( $product->currentlySelectedFit() );
    }
    
    function getCollection()
    {
        $collection = $this->doCollection();
        $collection->addStoreFilter($this->storeId);
        return $collection;
    }
    
    function getCollectionSize()
    {
        $size = 0;
        foreach( $this->getCollection() as $product )
        {
            $size += count( $product->getFits() );
        }
        return $size;
    }
    
    function doCollection()
    {
        $collection = new Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection;
        $collection->setStoreId(Mage::app()->getStore()->getId());
        $collection->addAttributeToSelect('*');
        
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
//        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
        return $collection;
    }
    
    function baseUrl($storeId = 0)
    {
        return Mage::getModel('core/store')->load($storeId ? $storeId : $this->storeId)->getBaseUrl();
    }
    
    function productUrl($product)
    {
        return $this->baseUrl().$this->getItemUrl($product);
    }
}