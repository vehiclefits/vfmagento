<?php
class Elite_Vaf_Adminhtml_Block_Catalog_Product_Edit_Tab_Vaf_AjaxTestStub extends Elite_Vaf_Adminhtml_Block_Catalog_Product_Edit_Tab_Vaf
{
    function toHtml()
    {
        require_once($this->designScriptPath() . '\adminhtml\default\default\template\catalog\product\tab\vaf.phtml');
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
        return 'F:\dev\vaf\app\code\local\Elite\Vaf\design';
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