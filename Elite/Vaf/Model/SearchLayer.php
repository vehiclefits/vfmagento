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
class Elite_Vaf_Model_SearchLayer extends Mage_CatalogSearch_Model_Layer
{
    
    public function prepareProductCollection($collection)
    {
        
        $collection
            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
            ->setStore(Mage::app()->getStore())
            ->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            ->addStoreFilter()
            ->addUrlRewrite();
        
        if(Mage::helper('catalogsearch')->getQuery()->getQueryText())
        {
            $collection->addSearchFilter(Mage::helper('catalogsearch')->getQuery()->getQueryText());
        }
        
        $ids = Elite_Vaf_Helper_Data::getInstance()->getProductIds();
        if($ids)
        {
            $collection->addIdFilter($ids);
        }
        
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInSearchFilterToCollection($collection);

        return $this;
    }
        

}