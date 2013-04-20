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
class VF_Level_Finder_Abstract implements VF_Configurable
{
    /** @var VF_Level_IdentityMap */
    protected $identityMap;
    
    /** @var Zend_Config */
    protected $config; 
    
    protected function getSchema()
    {
        $schema = new VF_Schema;
        $schema->setConfig( $this->getConfig() );
        return $schema;
    }
    
    function getConfig()
    {
        if( !$this->config instanceof Zend_Config )
        {
            
            $this->config = Elite_Vaf_Helper_Data::getInstance()->getConfig();
        }    
        return $this->config;
    }
    
    function setConfig( Zend_Config $config )
    {
        $this->config = $config;
    }
    
    function identityMap()
    {
        if(is_null($this->identityMap))
        {
            $this->identityMap = new VF_Level_IdentityMap;
        }
        return $this->identityMap;
    }
    
    /** @return Zend_Db_Statement_Interface */
    function query( $sql )
    {
        return $this->getReadAdapter()->query( $sql );
    }
    
    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }
    
    function getTable($table)
    {
        return 'elite_level_' . $this->getSchema()->id() . '_' . str_replace(' ','_',$table);
    }
}