<?php
class Elite_Vaf_Block_Search_TestSubClass extends Elite_Vaf_Block_Search
{
    protected $request;

    function setRequest( $request )
    {
        $this->request = $request;
    }
    
    function getRequest()
    {
        return $this->request;
    }
    
    
    
}