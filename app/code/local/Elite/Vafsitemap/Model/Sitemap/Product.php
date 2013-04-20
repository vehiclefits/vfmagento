<?php
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