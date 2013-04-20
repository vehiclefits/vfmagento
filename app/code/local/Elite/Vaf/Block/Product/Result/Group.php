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
class Elite_Vaf_Block_Product_Result_Group extends Elite_Vaf_Block_Product_Result
{
    function __construct()
    {
        parent::__construct();
        $this->setTemplate('vf/vaf/group/result.phtml');
    }
    
    /**
     * @param Varien_Data_Tree_Node $category
     * @param int $level
     * @param boolean $last
     * @return string
     */
    function drawItem($category, $categoryDepth=0, $last=false)
    {
        $html = '';
        if ( !$category->getIsActive() && !$this->categoryIsRoot( $category ) )
        {
            return $html;
        }

        if( !$this->categoryHasProductUnderIt( $category ) )
        {
            return;
        }
        
        $html.= '<li>';

        $html.= '<div class="vaf-cat-toggler">';
            $html .= $this->htmlEscape( $this->categoryName($category) );
            $html .= '<div class="vaf-toggle-icon vaf-toggle-icon-plus"></div>';
        $html .= '</div>'."\n";
        $html .= '<div class="vaf-toggle">';
            
        if ($category->hasChildren())
        {
            $htmlChildren = $this->drawCategoryCollection($category,$categoryDepth);
            if (!empty($htmlChildren))
            {
                $html.= '<ul >'."\n".$htmlChildren.'</ul>';
            }
        }
        
        $html .= $this->drawProductCollection($category);
            
        $html .= '</div>';  
        
        $html.= '</li>'."\n";
        return $html;
    }
    
    function drawCategoryCollection($category,$categoryDepth)
    {
        $j = 0;
        $htmlChildren = '';
        $childrenCount = $this->getCategoryChildCount($category);
        foreach ($this->getChildren($category) as $child)
        {
            if(!$child->getIsActive())
            {
                continue;
            }
            $htmlChildren.= $this->drawItem($child, $categoryDepth+1, ++$j >= $childrenCount);
        }

        return $htmlChildren;
    }
    
    function getCategoryChildCount($category)
    {
        if( !$category->hasChildren())
        {
            return 0;
        }
        
        $cnt = 0;
        foreach ($this->getChildren( $category ) as $child)
        {
            if (!$child->getIsActive())
            {
                continue;
            }
            $cnt++;
        }
        return $cnt;
    }
    
    function drawProductCollection($category)
    {
        $html = '';
        $products = $this->getProductCollectionGroupedByCategory(); 
        if( isset($products[ $category->getId() ] ) )
        {
            $_productCollection = $products[ $category->getId() ];
            $html .= $this->doDrawProductCollection( $_productCollection, $category );
        }
        else
        {
            $html .= ''; // no product
        }
        return $html;
    }
    
    function doDrawProductCollection( $collection, $category )
    {
        ob_start();
        $_iterator = 0; 
        foreach( $collection as $_product )
        {
            include( Mage::getDesign()->getTemplateFilename( 'vaf/group/result-item.phtml') );
        }  
        return ob_get_clean();
    }
}