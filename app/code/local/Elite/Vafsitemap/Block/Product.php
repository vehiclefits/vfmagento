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
class Elite_Vafsitemap_Block_Product extends Mage_Catalog_Block_Seo_Sitemap_Product
{
    /** @return VF_Vehicle */
    function getSelectedDefinition()
    {
        return $this->sitemap()->getSelectedDefinition();
    }   

    function getItemUrl($product)
    {
        return $this->sitemap()->getItemUrl($product);
    }
    
    function _prepareLayout()
    {
        $collection = $this->sitemap()->getCollection();
        $this->setCollection($collection);
        return $this;
    }
    
    function sitemap()
    {
        return new Elite_Vafsitemap_Model_Sitemap_Product_Html(VF_Singleton::getInstance()->getConfig());
    }
    
}
