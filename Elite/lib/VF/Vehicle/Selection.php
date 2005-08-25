<?php
class VF_Vehicle_Selection
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
    
    function earliestYear()
    {
        $earliestYear = null;
        foreach($this->vehicles as $vehicle)
        {
            if(is_null($earliestYear) || $vehicle->getLevel('year')->getTitle() < $earliestYear)
            {
                $earliestYear = $vehicle->getLevel('year')->getTitle();
            }
        }
        return $earliestYear;
    }
    
    
    function latestYear()
    {
        $latestYear = null;
        foreach($this->vehicles as $vehicle)
        {
            if(is_null($latestYear) || $vehicle->getLevel('year')->getTitle() > $latestYear)
            {
                $latestYear = $vehicle->getLevel('year')->getTitle();
            }
        }
        return $latestYear;
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