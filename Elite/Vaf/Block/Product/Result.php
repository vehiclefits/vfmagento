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
class Elite_Vaf_Block_Product_Result extends Elite_Vaf_Block_Product_List
{
    protected $_productCollection;
    
    protected function _beforeToHtml()
    {
    }
    
    protected function _prepareLayout()
    {
        $title = $this->getHeaderText();
        $this->getLayout()->getBlock('head')->setTitle($title);
        $this->getLayout()->getBlock('root')->setHeaderTitle($title);
        return parent::_prepareLayout();
    }

    function getHeaderText()
    {
        $fit = Elite_Vaf_Helper_Data::getInstance()->getFit();
        if( $fit )
        {            
            return Elite_Vaf_Helper_Data::getInstance()->__("Products for %s", $this->htmlEscape( $fit->__toString() ) );        
        }
        else
        {
            return false;
        }
    }

    function getSubheaderText()
    {
        return false;
    }

    /**
     * Get active status of category
     *
     * @param   Varien_Object $category
     * @return  bool
     */
    function isCategoryActive($category)
    {
        if ($this->getCurrentCategory()) {
            return in_array($category->getId(), $this->getCurrentCategory()->getPathIds());
        }
        return false;
    }
    
    function setListCollection() {
        $flexibleSearch = new Elite_Vaf_Model_FlexibleSearch(new Elite_Vaf_Model_Schema(), $this->getRequest());
        if($flexibleSearch->shouldClear())
        {
            return;
        }
        $this->getChild('search_result_list')
           ->setCollection($this->_getProductCollection());
    }

    function getProductListHtml()
    {
        return $this->getChildHtml('search_result_list');
    }

    protected function _getProductCollection()
    {
        if (is_null($this->_productCollection)) {
            $this->_productCollection = Mage::getSingleton('catalogsearch/layer')->getProductCollection();
        }
        
        return $this->_productCollection;
    }
    
    function getResultCount()
    {
        if (!$this->getData('result_count')) {
            $size = $this->_getProductCollection()->getSize();
            $this->setResultCount($size);
        }
        return $this->getData('result_count');
    }
    
    function getNoResultText()
    {
        return Elite_Vaf_Helper_Data::getInstance()->__('No matches found.');
    }
    
    function getProductCollectionGroupedByCategory()
    {
        $exclude = $this->getExcludeCategories();

        $collection = $this->getProductCollection();
        $return = array();
        foreach( $collection as $product )
        {
            $categoryIds = $this->removeRootCat( $product->getCategoryIds() );
            foreach( $categoryIds as $categoryId)
            {
                if( in_array( $categoryId, $exclude ) )
                {
                    continue;
                }
                $return[ $categoryId ][] = $product;
            }
        }
        return $return;
    }   

    function getProductCollection()
    {
        return $this->_getProductCollection();
    }
    
    protected function removeRootCat( $categoryIds )
    {
        $rootCat = Mage::app()->getStore()->getRootCategoryId();
        foreach( $categoryIds as $k=> $id )
        {
            if( $id == $rootCat )
            {
                unset( $categoryIds[ $k ] );
            }
        }
        return $categoryIds;
    }
    
    function getTotalCategoryCount()
    {
        $collection = $this->getProductCollectionGroupedByCategory();
        return count( $collection );
    }
    
    function getTotalProductCount()
    {
        $collection = $this->getProductCollectionGroupedByCategory();
        $count = 0;
        foreach( $collection as $categoryProducts )
        {
            $count += count( $categoryProducts );
        }
        return $count;
    }
    
    protected function getExcludeCategories()
    {
        $exclude = explode( ',', Elite_Vaf_Helper_Data::getInstance()->getConfig()->homepagesearch->exclude_categories );
        return $exclude;
    }
    
    function getCategories()
    {
        $helper = Mage::helper('catalog/category');
        return $helper->getStoreCategories();
    }
    
    protected function getRecursiveProductCount( $category )
    {
        $count = 0;
        $children = $this->getChildren( $category );
        foreach( $children as $child )
        {
            $count += $this->getRecursiveProductCount( $child );
        }
        $products = $this->getProductCollectionGroupedByCategory();
        $count += isset( $products[ $category->getId() ] ) ? count( $products[ $category->getId() ] ) : 0;
        return $count;
    }
    
    protected function getChildren( $category )
    {
        if (Mage::helper('catalog/category_flat')->isEnabled())
        {
            $children = $category->getChildrenNodes();
        }
        else
        {
            $children = $category->getChildren();
        }
        return $children;
    }
    
    /**
     * Retrieve categories
     *
     * @param integer $node_id
     */
    function getNode( $node_id )
    {
        $tree = Mage::getResourceModel('catalog/category_tree');
        /** @var $tree Mage_Catalog_Model_Resource_Eav_Mysql4_Category_Tree */
        $nodes = $tree->loadNode( $node_id );
        return $nodes;
    }
    
    /** @param Varien_Data_Tree_Node $category */
    function categoryIsRoot( $category )
    {
        return $category->getId() == Mage::app()->getStore()->getRootCategoryId();
    }
    
    function categoryHasProductUnderIt( $category )
    {
        $return = false;
        
        $products = $this->getProductCollectionGroupedByCategory();
        $segment = isset( $products[ $category->getId() ] ) ? $products[ $category->getId() ] : array();
        if( count( $segment ) )
        {
            $return = true;
        }            
        
        $children = $category->getChildren();
        if( $children->count() > 0 )
        {
            foreach( $children as $child_category )
            {
                if( $this->categoryHasProductUnderIt( $child_category ) )
                {
                    $return = true;
                }
            }
        }
        return $return;
    }
    
    function categoryName($category)
    {
        return $this->categoryIsRoot( $category ) ? 'Uncategorized' : $category->getName();
    }
    
	function categoryUrl($category)
    {
		return $this->baseUrl() . $category->getRequestPath();    	
    }
    
	function baseUrl($storeId = 0)
    {
        return Mage::getBaseUrl();
    }
}