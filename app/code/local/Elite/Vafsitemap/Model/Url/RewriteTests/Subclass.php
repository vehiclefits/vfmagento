<?php
class Elite_Vafsitemap_Model_Url_RewriteTests_Subclass extends Elite_Vafsitemap_Model_Url_Rewrite
{
    protected $id;
    
    function rewrite(Zend_Controller_Request_Http $request=null, Zend_Controller_Response_Http $response=null)
    {            
        return parent::rewrite($request,$response);
    }
    
    function getStoreId()
    {
        return 1;
    }
    
    function setId($id)
    {
        $this->id = $id;
    }
    
    function getId()
    {
        return $this->id;
    }
    
    function load($id, $field=null)
    {
        if( 'test.html' == $id && 'request_path' == $field )
        {
            $this->setId(1);
        }
    }
    
    function getTargetPath()
    {
        return '/catalog/product/view/id/1';
    }
    
}