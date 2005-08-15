<?php
class Elite_Vafsitemap_Block_Product extends Mage_Catalog_Block_Seo_Sitemap_Product
{
    /** @return Elite_Vaf_Model_Vehicle */
    function getSelectedDefinition()
    {
        return $this->sitemap()->getSelectedDefinition();
    }   

    function getItemUrl($product)
    {
        return $this->sitemap()->getItemUrl($product);
    }
    
    function _prepareLayout()
    {
        $collection = $this->sitemap()->getCollection();
        $this->setCollection($collection);
        return $this;
    }
    
    function sitemap()
    {
        return new Elite_Vafsitemap_Model_Sitemap_Product_Html(Elite_Vaf_Helper_Data::getInstance()->getConfig());
    }
    
}
