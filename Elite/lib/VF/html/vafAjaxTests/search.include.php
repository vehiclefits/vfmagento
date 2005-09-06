<?php
class Elite_Vaf_Block_Search_AjaxTestSub extends Elite_Vaf_Block_Search
{
    function toHtml()
    {
        Elite_Vaf_Helper_Data::getInstance()->setRequest( new Zend_Controller_Request_Http() );
        require('F:\dev\vaf\app\code\local\Elite\Vaf\design\frontend\default\default\template\vaf\search.phtml');
    }

    function url( $url )
    {
    }
    
    function getHeaderText()
    {
        return ('Search By Vehicle');
    }
    
    function getSubmitText()
    {
        return ('Search');
    }
    
}