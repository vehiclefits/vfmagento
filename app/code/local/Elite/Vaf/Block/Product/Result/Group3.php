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
class Elite_Vaf_Block_Product_Result_Group3 extends Elite_Vaf_Block_Product_Result
{
	function __construct()
    {
        parent::__construct();
        $this->setTemplate('vf/vaf/group3/result.phtml');
    }
    
	function categoryUrl($category)
    {
    	// have to force magento to load it it seems.
    	$category = Mage::getModel('catalog/category')->load($category->getId());
    	
    	$pathIds = $category->getPathIds();
    	array_shift($pathIds);
    	array_shift($pathIds);
    	
    	$uri = '?';
		$uri .= 'category1=' . current($pathIds);    	
		$uri .= '&category2=' . next($pathIds);    	
		$uri .= '&category3=' . next($pathIds);
		return $uri;    	
    }
    
    function currentLevel()
    {
    	$category1 = $this->getRequest()->getParam('category1');
    	$category2 = $this->getRequest()->getParam('category2');
    	$category3 = $this->getRequest()->getParam('category3');
    	$category4 = $this->getRequest()->getParam('category4');
    	
    	$level = $category1 ? 2 : 1;
    	$level = $category2 ? 3 : $level;
    	$level = $category3 ? 4 : $level;
    	
    	return $category;
    }
    
    function currentCategory()
    {
    	$category1 = $this->getRequest()->getParam('category1');
    	$category2 = $this->getRequest()->getParam('category2');
    	$category3 = $this->getRequest()->getParam('category3');
    	$category4 = $this->getRequest()->getParam('category4');
    	
    	if($category1||$category2||$category3)
    	{
    		// find the deepest requested category
    		$category = $category1;
    		$category = $category2 ? $category2 : $category;
    		$category = $category3 ? $category3 : $category;
    		$category = $category4 ? $category4 : $category;
    	}
    	return $category;
    }
    
	function getCategories()
    {
    	$category1 = $this->getRequest()->getParam('category1');
    	$category2 = $this->getRequest()->getParam('category2');
    	$category3 = $this->getRequest()->getParam('category3');
    	$category4 = $this->getRequest()->getParam('category4');
    	
    	if($category1||$category2||$category3)
    	{
    		// find the deepest requested category
    		$category = $category1;
    		$category = $category2 ? $category2 : $category;
    		$category = $category3 ? $category3 : $category;
    		$category = $category4 ? $category4 : $category;

			$category = Mage::getModel('catalog/category')->load($category);
			return $this->getChildrenModels($category);
    	}
    	else
    	{
	        $helper = Mage::helper('catalog/category');
	        return $helper->getStoreCategories();
    	}
    }
    
    function getChildrenModels($category)
    {
    	$childrenIds = $this->getChildren($category);
    	if(!$childrenIds)
    	{
    		return array();
    	}
    	$childrenIds = explode(',', $childrenIds);
    	$children = array();
    	foreach($childrenIds as $childId)
    	{
    		array_push($children, Mage::getModel('catalog/category')->load($childId));
    	}
    	return $children;
    }
}