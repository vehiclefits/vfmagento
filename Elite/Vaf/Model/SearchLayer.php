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
class Elite_Vaf_Model_SearchLayer extends Mage_CatalogSearch_Model_Layer
{

    /**
     * I know its crap, but Magento sucks.
     * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection
     */
    function getProductCollection()
    {
        if (isset($this->_productCollections[$this->getCurrentCategory()->getId()]))
        {
            $collection = $this->_productCollections[$this->getCurrentCategory()->getId()];
        } else
        {
            $ids = Elite_Vaf_Helper_Data::getInstance()->getProductIds();



            if (Mage::helper('catalogSearch')->getEscapedQueryText() && Mage::getStoreConfig('catalog/search/filtering', Mage::app()->getStore()->getStoreId()))
            {

                $collection = Mage::getResourceModel('catalogsearch/fulltext_collection')
                                ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                                ->addSearchFilter(Mage::helper('catalogSearch')->getEscapedQueryText())
                                ->addIdFilter($ids)
                                ->setStore(Mage::app()->getStore())
                                ->addMinimalPrice()
                                ->addFinalPrice()
                                ->addTaxPercents()
                                ->addStoreFilter()
                                ->addUrlRewrite();

                Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
                // Comment out following line for work-around for:
                // 0000295: Group View not Displaying products, but products show in browsing
                Mage::getSingleton('catalog/product_visibility')->addVisibleInSearchFilterToCollection($collection);
            } elseif (!Mage::helper('catalogSearch')->getEscapedQueryText())
            {

                $collection = Mage::getResourceModel('catalog/product_collection')
                                ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                                ->setStore(Mage::app()->getStore())
                                ->addMinimalPrice()
                                ->addFinalPrice()
                                ->addTaxPercents()
                                ->addStoreFilter()
                                ->addUrlRewrite();

                if($ids)
                {
                    $collection->addIdFilter($ids);
                }

                Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
                // Comment out following line for work-around for:
                // 0000295: Group View not Displaying products, but products show in browsing
                Mage::getSingleton('catalog/product_visibility')->addVisibleInSearchFilterToCollection($collection);
            } else
            {

                $collection = Mage::getResourceModel('catalogsearch/fulltext_collection');
                $this->prepareProductCollection($collection);
            }


            $this->_productCollections[$this->getCurrentCategory()->getId()] = $collection;
        }

        return $collection;
    }

}