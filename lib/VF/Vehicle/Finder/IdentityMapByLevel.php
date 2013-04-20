<?php
class VF_Vehicle_Finder_IdentityMapByLevel
{
    protected $vehicles = array();
    
    static function getInstance()
    {
        static $instance;
        if(is_null($instance))
        {
            $instance = new VF_Vehicle_Finder_IdentityMapByLevel;
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
        $this->vehicles = array();
    }
    
    function add($vehicle)
    {
        array_push($this->vehicles,$vehicle);
    }
    
    function remove($vehicle)
    {
        
    }
    
    function has($level,$id)
    {
        foreach($this->vehicles as $vehicle)
        {
            if( $vehicle->getValue($level) == $id )
            {
                return true;
            }
        }
        return false;
    }
    
    function get($level,$id)
    {
        foreach($this->vehicles as $vehicle)
        {
            if( $vehicle->getValue($level) == $id )
            {
                return $vehicle;
            }
        }
    }
}