<?php
class Elite_Vaf_Block_Search_Choosevehicle_AjaxTestSub extends Elite_Vaf_Block_Search_Choosevehicle
{
    function toHtml()
    {
        require('F:\dev\vaf\app\code\local\Elite\Vaf\design\frontend\default\default\template\vaf\search.phtml');
    }

    function __()
    {
        $args = func_get_args();
        return $args[0];
    }

    protected function url( $url )
    {
    }
    
}
$search = new Elite_Vaf_Block_Search_Choosevehicle_AjaxTestSub();
if( isset( $config) )
{
    $search->setConfig($config);
}
Elite_Vaf_Helper_Data::getInstance()->setRequest( new Zend_Controller_Request_Http() );
$search->toHtml();