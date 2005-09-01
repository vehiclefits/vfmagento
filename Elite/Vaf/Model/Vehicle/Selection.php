<?php
class Elite_Vaf_Model_Vehicle_Selection
{
    public $vehicles;
    
    function __construct($vehicles)
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
    
}