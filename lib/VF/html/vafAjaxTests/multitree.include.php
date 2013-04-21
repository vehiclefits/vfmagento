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
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Elite_Vaf_Adminhtml_Block_Catalog_Product_Edit_Tab_Vaf_AjaxTestStub extends Elite_Vaf_Adminhtml_Block_Catalog_Product_Edit_Tab_Vaf
{
    function toHtml()
    {
        require_once($this->designScriptPath() . '/adminhtml/default/default/template/catalog/product/tab/vaf.phtml');
    }
    
    function getProduct()
    {
        return new Elite_Vaf_Model_Catalog_Product();
    }
    
    function renderConfigurations()
    {
        
    }
    
    function designScriptPath()
    {
        return getenv('PHP_MAGE_PATH').'/app/design';
    }
    
    function getUrl( $routeString )
    {
        return '/' . str_replace('*','admin',$routeString);
    }
    
    function __()
    {
        $args = func_get_args();
        return $args[0];
    }
    
    function htmlEscape( $string )
    {
        return htmlentities($string);
    }
}