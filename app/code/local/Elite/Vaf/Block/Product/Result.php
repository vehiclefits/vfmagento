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

class Elite_Vaf_Block_Product_Result extends Elite_Vaf_Block_Product_List
{
    protected $_productCollection;
    static $productCollectionGroupedByCategory;
    
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
        $fit = VF_Singleton::getInstance()->vehicleSelection();
        if( $fit )
        {            
            return $this->translate("Products for %s", htmlentities( $fit->__toString() ) );
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
        $flexibleSearch = new VF_FlexibleSearch(new VF_Schema(), $this->getRequest());
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
        return $this->translate('No matches found.');
    }
    
    function getProductCollectionGroupedByCategory()
    {
        if(isset(self::$productCollectionGroupedByCategory))
        {
            return self::$productCollectionGroupedByCategory;
        }
        $exclude = $this->getExcludeCategories();

        $collection = $this->getProductCollection();
        $return = array();
        
        // get product's Ids
        $ids = array();
        foreach( $collection as $product )
        {
            $ids[] = $product->getId();
            $products[$product->getId()] = $product;
        }

        $productCategories = $this->productCategoryHashMap($ids);
        
        //// loop over products building formatted array
        foreach( $productCategories as $row )
        {
            $product = $products[$row['product_id']];
            $category = $row['category_id'];

            if(!isset($return[$category]))
            {
                $return[$category] = array();
            }
                
            if( in_array($product, $return[$category]))
            {
                continue;
            }
            $return[ $category ][] = $product;
        }
        
        self::$productCollectionGroupedByCategory = $return;
        return $return;
    }   
    
    function productCategoryHashMap($ids)
    {
        // get product ID <-> category ID array
        $select = VF_Singleton::getInstance()->getReadAdapter()
                    ->select()
                    ->from('catalog_category_product_index', array('category_id','product_id'))
                    ->where('product_id IN (' . implode(',',$ids) .')')
                    ->where('category_id != ' . Mage::app()->getStore()->getRootCategoryId())
                    ->group('category_id');
        $this->doProductCategoryHashMap($select);
        return $select->query()->fetchAll();
    }
    
    function doProductCategoryHashMap($select)
    {
        $select->group('product_id');
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
        $collection = $this->getProductCollection();
        return $collection->getSize();
    }
    
    protected function getExcludeCategories()
    {
        $exclude = explode( ',', VF_Singleton::getInstance()->getConfig()->homepagesearch->exclude_categories );
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

    function translate($text)
    {
        if(defined('ELITE_TESTING')) {
            return $text;
        }
        return Mage::helper('catalog/product')->__($text);
    }
}