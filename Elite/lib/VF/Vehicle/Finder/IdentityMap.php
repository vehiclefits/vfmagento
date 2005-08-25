<?php
class VF_Vehicle_Finder_IdentityMap
{
    protected $vehicles = array();
    
    static function getInstance()
    {
        static $instance;
        if(is_null($instance))
        {
            $instance = new VF_Vehicle_Finder_IdentityMap;
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
        throw new Exception('todo');
    }
    
    function has($id)
    {
        foreach($this->vehicles as $vehicle)
        {
            if( $vehicle->getId() == $id )
            {
                return true;
            }
        }
        return false;
    }
    
    function get($id)
    {
        foreach($this->vehicles as $vehicle)
        {
            if( $vehicle->getId() == $id )
            {
                return $vehicle;
            }
        }
    }
}