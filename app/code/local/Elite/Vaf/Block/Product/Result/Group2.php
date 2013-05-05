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

class Elite_Vaf_Block_Product_Result_Group2 extends Elite_Vaf_Block_Product_Result
{
    function __construct()
    {
        parent::__construct();
        $this->setTemplate('vf/vaf/group2/result.phtml');
    }
    
    // this is to null out functionality that adds 'group by' on the `product_id` field. SInce we only care about category IDs in group2, this is less rows.
    function doProductCategoryHashMap($select)
    {
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
        
        $html .= '<strong><a href="' . $this->categoryUrl($category) . '">' . $this->htmlEscape($category->getName()) . '</a></strong>';
        
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
        return '<li>- <a href="' . $this->baseUrl() . $category->getRequestPath() . '">' . $this->htmlEscape($category->getName()) . '</a></li>';
    }

    function imagePath($category)
    {
        $name = $category->getName();
        $name = str_replace(' ','-',$name);
        $name = strtolower($name);
        return $name;
    }
}