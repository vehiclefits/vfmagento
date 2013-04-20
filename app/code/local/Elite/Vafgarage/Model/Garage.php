<?php

class Elite_Vafgarage_Model_Garage {

    protected $vehicles = array();

    function addVehicle($vehicle) {
        if ($this->hasVehicle($vehicle)) {
            return false;
        }
        $this->vehicles[] = $vehicle;
    }

    function removeVehicle($vehicle) {
        foreach ($this->vehicles() as $key => $eachVehicle) {
            if ($vehicle === $eachVehicle) {
                unset($this->vehicles[$key]);
            }
        }
    }

    function hasVehicle($vehicle) {
        foreach ($this->vehicles() as $eachVehicle) {
            if ($vehicle === $eachVehicle) {
                return true;
            }
        }
        return false;
    }

    function vehicles() {
        return $this->vehicles;
    }

}