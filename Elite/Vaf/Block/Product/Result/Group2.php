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
class Elite_Vaf_Block_Product_Result_Group2 extends Elite_Vaf_Block_Product_Result
{
    function __construct()
    {
        parent::__construct();
        $this->setTemplate('vaf/group2/result.phtml');
    }
    
    function drawItem($category, $level=0, $last=false)
    {
        $html = '';
        if ( !$category->getIsActive() && !$this->categoryIsRoot($category) )
        {
            return $html;
        }
        
        if( !$this->categoryHasProductUnderIt($category) )
        {
            return;
        }

        $html.= '<div class="vaf-cat">';
            $html .= $this->renderParent($category);
        $html .= '</div>';  
        
        return $html;
    }
    
    function renderParent($category)
    {
        $html = '<img align="left" src="/category-images/' . $this->htmlEscape($this->imagePath($category)) . '.jpg" />';
        
        $html .= '<strong><a href="/'.$category->getRequestPath().'">'.$this->htmlEscape($category->getName()).'</a></strong>';
        
        if ($category->hasChildren())
        {
            $html .= '<ul>';
            foreach ($this->getChildren($category) as $child)
            {
                $html .= $this->renderChild($child);
            }
            $html .= '</ul>';
        }
        return $html;
    }
    
    function renderChild($category)
    {
        if( !$category->getIsActive() || !$this->categoryHasProductUnderIt($category) )
        {
            return '';
        }
        return '<li>- <a href="/'.$category->getRequestPath().'">'.$this->htmlEscape($category->getName()).'</a></li>';
    }
    
    function imagePath($category)
    {
        $name = $category->getName();
        $name = str_replace(' ','-',$name);
        $name = strtolower($name);
        return $name;
    }
}