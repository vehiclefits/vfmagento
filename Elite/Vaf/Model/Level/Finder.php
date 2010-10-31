<?php
/**
* Vehicle Fits Free Edition - Copyright (c) 2008-2010 by Ne8, LLC
* PROFESSIONAL IDENTIFICATION:
* "www.vehiclefits.com"
* PROMOTIONAL SLOGAN FOR AUTHOR'S PROFESSIONAL PRACTICE:
* "Automotive Ecommerce Provided By Ne8 llc"
*
* All Rights Reserved
* VEHICLE FITS ATTRIBUTION ASSURANCE LICENSE (adapted from the original OSI license)
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the conditions in license.txt are met
*/
class Elite_Vaf_Model_Level_Finder extends Elite_Vaf_Model_Level_Finder_Abstract
{
    static function getInstance()
    {
        static $finder;
        if( is_null( $finder ) )
        {
            $finder = new Elite_Vaf_Model_Level_Finder();
        }
        return $finder;
    }
    
    function find( $level, $id )
    {
        return $this->selector()->find($level, $id);
    }
    
    /** @return Elite_Vaf_Model_Level */
    function findEntityByTitle( $type, $title, $parent_id = 0 )
    { 
        return $this->selector()->findEntityByTitle( $type, $title, $parent_id );
    }
    
    /** @return integer ID */
    function findEntityIdByTitle( $type, $title, $parent_id = 0 )
    {
        return $this->selector()->findEntityIdByTitle( $type, $title, $parent_id );
    }
    
    /**
    *  @param mixed Elite_Vaf_Model_Level|string name of level type
    * @param mixed $parent_id
    */
    function listAll( $level, $parent_id = 0 )
    {
        if(is_string($level))
        {
            $level = new Elite_Vaf_Model_Level($level);
        }
        return $this->selector()->listAll( $level, $parent_id );
    }
    
    /**
    * @param aray $slaveLevels - Ex. array('year'=>$year1,'year'=>$year2);
    * @param array $masterLevel - Ex. array('year'=>$year2);
    */
    function merge( $slaveLevels, $masterLevel )
    {
        $merge = new Elite_Vaf_Model_Merge();
        $merge->merge($slaveLevels, $masterLevel);
    }
    
    function __call($name, $arguments)
    {
        return call_user_func_array(array($this->selector(),$name), $arguments);
    }
    
    function selector()
    {
        return new Elite_Vaf_Model_Level_Finder_Selector;
    }
    
}