<?php
class Elite_Vaf_Model_Vehicle_Selection
{
    public $vehicles;
    
    function __construct($vehicles=array())
    {
        if(is_array($vehicles))
        {
            $this->vehicles = $vehicles;
        }
        else
        {
            $this->vehicles = array($vehicles);
        }
    }
    
    function getFirstVehicle()
    {
        if(isset($this->vehicles[0]))
        {
            return $this->vehicles[0];
        }
    }
    
    function contains($vehicle)
    {
        foreach($this->vehicles as $thisVehicle)
        {
            if($vehicle->toValueArray() == $thisVehicle->toValueArray())
            {
                return true;
            }
        }
        return false;
    }
    
    function __call($methodName,$arguments)
    {
        if($this->isEmpty())
        {
            return;
        }
        
        $method = array($this->getFirstVehicle(),$methodName);
        return call_user_func_array( $method, $arguments );
    }
    
    function __toString()
    {
        if($this->isEmpty())
        {
            return '';
        }
        return $this->getFirstVehicle()->__toString();
    }
    
    function isEmpty()
    {
        return 0 == count($this->vehicles);
    }
}