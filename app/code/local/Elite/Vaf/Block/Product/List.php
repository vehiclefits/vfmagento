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

class Elite_Vaf_Block_Product_List extends Mage_Catalog_Block_Product_List
{
    function getLoadedProductCollection()
    {
        $collection = $this->_getProductCollection();
        $filter = new Elite_Vaf_Model_Catalog_Category_FilterImpl();
        $category = Mage::registry('current_category');
        if( !is_object($category ) )
        {
            return $collection;
        }
        $category_id = $category->getId();
        if( $filter->shouldShow( $category_id ) )
        {
            $this->applyNames( $collection );
        }
        return $collection;
    }
    
    /** @todo write acceptance test 0000328: Elite_Vaf_Block_Product_List should not depend on SEO module being present */
    protected function applyNames( $collection )
    {
        if( class_exists( 'Elite_Vafsitemap_Helper_SeoName', false ) )
        {
            $helper = new Elite_Vafsitemap_Helper_SeoName();
            foreach( $collection as $product )
            {
                $helper->applyName( $product );
            }
        }
    }
       
}