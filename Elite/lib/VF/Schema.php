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
class VF_Schema implements
    VF_Schema_Interface,
    Elite_Vaf_Configurable
{
    /** @var Zend_Config */
    protected $config;
    
    static public $levels;
    
    static public $global_status;
       
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
    
    function getLeafLevel()
    {
        $levels = $this->getLevels();
        $leaf = $levels[ count( $levels ) - 1 ];
        return $leaf;
    }
    
    function getRootLevel()
    {
        $levels = $this->getLevels();
        $root = $levels[ 0 ];
        return $root;
    }

    function getLevelsString()
    {
	$levelsString = array();
	foreach($this->getLevels() as $level)
	{
	    $levelsString[] = '`' . $level . '`';
	}
	return implode(',',$levelsString);
    }
    
    function getLevels()
    {
        $levels = self::$levels;
        
        if( is_array($levels) && count($levels) )
        {
            return $levels;
        }
        
        $select = $this->getReadAdapter()->select()
            ->from('elite_schema', 'value')
            ->where('`key`=?','levels');
        $levels = $select->query()->fetchColumn();
        
        $levels = explode( ',', $levels );
        foreach( $levels as $k => $level )
        {
            $levels[ $k ] = trim( $level );
        }
        return self::$levels = $levels;
    }

    function getRewriteLevels()
    {
	if($this->getConfig()->seo->rewriteLevels)
	{
	    return explode(',', $this->getConfig()->seo->rewriteLevels );
	}
	return $this->getLevels();
    }
    
    /**
    * Get the level that comes immediatly previous to the requested level, or false if none
    * @param string $level
    * @return mixed string level, false if none
    */
    function getPrevLevel( $level )
    {
        $levels = $this->getLevels();
        $level_incdeces = $this->getLevelIndeces();
        $level_index = $level_incdeces[ $level ];
        if( !isset( $levels[ $level_index - 1 ] ) )
        {
            return false;
        }
        $prev_level = $levels[ $level_index - 1 ];
        return $prev_level;
    }
    
    /**
    * Get levels that come previous to the requested level. Does not include the requested level in the return array
    * @param string $deltaLevel Name of level
    * @return array of level names
    */
    function getPrevLevels($deltaLevel)
    {
        $return = array();
        foreach( $this->getLevels() as $level )
        {
            if( $deltaLevel == $level )
            {
                return $return;
            }
            $return[] = $level;
        }
        return $return;
    }
    
    /**
    * Get levels that come previous to the requested level, including the requested level. Includes the requested level in the return array
    * @param string $deltaLevel Name of level
    * @return array of level names
    */
    function getPrevLevelsIncluding($deltaLevel)
    {
        $return = array();
        foreach( $this->getLevels() as $level )
        {
            $return[] = $level;
            if( $deltaLevel == $level )
            {
                return $return;
            }
        }
        return $return;
    }
    
    /**
    * Get the level that comes immediatly after to the requested level, or false if none
    * @param string $level
    * @return mixed string level, false if none
    */
    function getNextLevel( $level )
    {
        $levels = $this->getLevels();
        $level_incdeces = $this->getLevelIndeces();
        $level_index = $level_incdeces[ $level ];
        if( !isset($levels[ $level_index + 1 ]) )
        {
            return false;
        }
        $next_level = $levels[ $level_index + 1 ];
        return $next_level;
    }
    
    /**
    * Get levels that come after to the requested level, not including the requested level
    * @param string $deltaLevel Name of level
    * @return array of level names
    */
    function getNextLevels($deltaLevel)
    {
        $prevLevels = $this->getPrevLevels($deltaLevel);
        $return = $this->getLevels();
        foreach($return as $key => $level )
        {
            if( in_array($level,$prevLevels) || $level == $deltaLevel )
            {
                unset($return[$key]);
            }
        }
        return array_values($return);
    }
    
    /**
    * Get levels that come after to the requested level, including the requested level.
    * @param string $deltaLevel Name of level
    * @return array of level names
    */
    function getNextLevelsIncluding($deltaLevel)
    {
        $prevLevels = $this->getPrevLevels($deltaLevel);
        $return = $this->getLevels();
        foreach($return as $key => $level )
        {
            if( in_array($level,$prevLevels) )
            {
                unset($return[$key]);
            }
        }
        return array_values($return);
    }
    
    /**
    * Returns true only if $level comes before $compareLevel
    * @param string $level
    * @param string $compareLevel
    */
    function levelIsBefore( $level, $compareLevel )
    {
        $level_incdeces = $this->getLevelIndeces();
        $level_index = $level_incdeces[ $level ];
        $level_index_compare = $level_incdeces[ $compareLevel ];
        return $level_index < $level_index_compare; 
    }
    
    function getLevelsExceptLeaf()
    {
        return $this->getLevelsExcluding($this->getLeafLevel());
    }
    
    function getLevelsExceptRoot()
    {
        return $this->getLevelsExcluding($this->getRootLevel());
    }
    
    function getLevelsExcluding($excludeLevel)
    {
        $return = array();
        foreach( $this->getLevels() as $level )
        {
            if( $excludeLevel != $level )
            {
                array_push( $return, $level );
            }
        }
        return $return;
    }
    
    function hasGlobalLevel()
    {
        foreach($this->getLevels() as $level)
        {
            if($this->isGlobal($level))
            {
                return true;
            }
        }
        return false;
    }
    
    function isGlobal($level)
    {
        if( isset(self::$global_status[$level]))
        {
            return self::$global_status[$level];
        }
        
        $key = $level.'_global';
        return self::$global_status[$level] = (bool)$this->readSchemaRegistryKey($key);
    }
    
    function hasParent($level)
    {
        return !$this->isGlobal($level);
    }
    
    function getSorting($level)
    {
        $key = $level.'_sorting';
        return $this->readSchemaRegistryKey($key);
    }
    
    function readSchemaRegistryKey($key)
    {
        $select = $this->getReadAdapter()->select()
            ->from('elite_schema',array('value'))
            ->where('`key`=?',$key)
            ->limit(1);
        $result = $this->getReadAdapter()->query($select);
        return $result->fetchColumn();
    }
    
    /** @return Zend_Db_Adapter_Abstract */
    function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }
    
    static function reset()
    {
        self::$levels = '';
		self::$global_status = '';
    }
    
    protected function getLevelIndeces()
    {
        return array_flip( $this->getLevels() );
    }
}