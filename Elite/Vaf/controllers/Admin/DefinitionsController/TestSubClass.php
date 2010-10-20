<?php
class Elite_Vaf_Admin_DefinitionsController_TestSubClass extends Elite_Vaf_Admin_DefinitionsController
{
    protected $request;
    
//    function __construct()
//    {
//    }
    
    function setRequest( $request )
    {
        $this->request = $request;
    }
    
    function getRequest()
    {
        return $this->request;
    }
    
    
    protected function getEditUrl( $id )
    {

    }
    
    protected function getDeleteUrl( $id, $confirm = 0 )
    {

    }
    
    protected function getListUrl( $entityType, $id )
    {

    }
    
    protected function getSaveUrl( $id )
    {

    }
    
    protected function getAddUrl()
    {

    }
    
    protected function doSave()
    {
        
    }
    
}