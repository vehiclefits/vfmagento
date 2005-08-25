<?php
/**
* Vehicle Fits Free Edition - Copyright (c) 2008-2010 by Vehicle Fits, LLC
* PROFESSIONAL IDENTIFICATION:
* "www.vehiclefits.com"
* PROMOTIONAL SLOGAN FOR AUTHOR'S PROFESSIONAL PRACTICE:
* "Automotive Ecommerce Provided By Vehicle Fits llc"
*
* All Rights Reserved
* VEHICLE FITS ATTRIBUTION ASSURANCE LICENSE (adapted from the original OSI license)
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the conditions in license.txt are met
*/
class Elite_Vaf_Block_Search_Choosevehicle extends Elite_Vaf_Block_Search
{
    protected $product_id;
    
    function __construct()
    {
         parent::__construct();
         $this->setTemplate('vaf/search.phtml');
	}
	
    function action()
    {
        return '?';
    }
    
    protected function _toHtml()
    {
        if (!$this->getTemplate()) {
            return '';
        }
        $html = $this->renderView();
        return $html;
    }
    
    protected function getHeaderText()
    {
        return 'Choose your Vehicle';
    }
    
    function showClearButton()
    {
        return false;
    }
    
    function getSubmitText()
    {
        return 'Choose';
    }
    
    function listEntities( $level )
    {
        if($level != $this->getSchema()->getRootLevel() )
        {
            return array();
        }
        $entity = new VF_Level( $level );
        return $entity->listInUse( $this->getRequestLevels(), $this->getProductId() );           
    }
    
    function setProductId( $product_id )
    {
        $this->product_id = $product_id;
    }
    
    function getProductId()
    {
        return $this->product_id;
    }
    
    function showCategoryChooser()
    {
        return false;
    }
    
    function showSubmitButton()
    {
        return true;
    }
    
    function getMethod()
    {
        return 'POST';
    }
    
    function formId()
    {
        return 'vafChooserForm';
    }

}
