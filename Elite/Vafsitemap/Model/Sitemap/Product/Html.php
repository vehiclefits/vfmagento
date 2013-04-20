<?php
class Elite_Vafsitemap_Model_Sitemap_Product_Html extends Elite_Vafsitemap_Model_Sitemap_Product
{
	/** for test only */
    public $filtered = false;
    
    /** @return VF_Vehicle */
    function getSelectedDefinition()
    {
        return Elite_Vaf_Helper_Data::getInstance()->vehicleSelection();
    }
    
    function getCollection()
    {
		$collection = $this->doCollection();
        $this->filterCollectionByVehicle($collection);
        return $collection;
    }
    
    function doCollection()
    {
		$collection = new Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection;
        $collection->setStoreId(Mage::app()->getStore()->getId());
        $collection->addAttributeToSelect('*');
        $collection->addStoreFilter();
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
        return $collection;
    }
    
    function filterCollectionByVehicle($collection)
    {
		$ids = Elite_Vaf_Helper_Data::getInstance()->getProductIds();
        $collection->addIdFilter( $ids );
        $this->filtered = true;
    }

}