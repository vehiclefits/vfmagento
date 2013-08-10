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
            include( Mage::getDesign()->getTemplateFilename( 'vf/vaf/group/result-item.phtml') );
        }  
        return ob_get_clean();
    }
}