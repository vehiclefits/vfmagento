<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
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