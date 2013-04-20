<?php
class VF_Level_IdentityMap
{
    protected $levels = array();
    
    static function getInstance()
    {
        static $instance;
        if(is_null($instance))
        {
            $instance = new VF_Level_IdentityMap;
        }
        return $instance;
    }
    
    /** TEST ONLY */
    static function reset()
    {
        self::getInstance()->doReset();
    }
    
    /** TEST ONLY */
    function doReset()
    {
        $this->levels = array();
    }
    
    function add($level)
    {
        array_push($this->levels,$level);
    }
    
    function remove($level)
    {
        
    }
    
    function has($level,$id)
    {
        foreach($this->levels as $level)
        {
            if($level->getType() == $level && $level->getId() == $id )
            {
                return true;
            }
        }
        return false;
    }
    
    function get($level,$id)
    {
        foreach($this->levels as $level)
        {
            if($level->getType() == $level && $level->getId() == $id )
            {
                return $level;
            }
        }
    }
}