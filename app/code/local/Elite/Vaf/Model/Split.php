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
 * to sales@vehiclefits.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Elite_Vaf_Model_Split extends Elite_Vaf_Model_Base
{
    /** @var VF_Vehicle */
    protected $vehicle;
    protected $vehicleObj;
    protected $grain, $newTitles;
    
    function __construct( $vehicle, $grain, $newTitles )
    {
        $this->vehicle = $vehicle;
        $this->grain = $grain;
        $this->newTitles = $newTitles;
    }
    
    function execute()
    {
        if(!$this->grain)
        {
            throw new Elite_Vaf_Model_Split_Exception('no grain');
        }
        $descendants = $this->vehicleDescendants();
        $this->ensureCompatible($descendants);
        foreach($descendants as $descendant)
        {
            $this->apply($descendant);
        }
        if(count($descendants) && $this->shouldDeleteOldVehicle()  )
        {
            $this->vehicle()->unlink();
        }
    }
    
    function ensureCompatible($descendants)
    {
    	if( file_exists(ELITE_PATH.'/Vafpaint') )
    	{
	    	$paintValidator = new Elite_Vafpaint_Model_MergeValidator;
	    	$paintValidator->ensureCompatible($descendants, $this->vehicle);
    	}    
    }
    
    function shouldDeleteOldVehicle()
    {
    	$oldVehiclesTitleForCurrentOperatingLevel = $this->vehicle()->getLevel($this->grain)->getTitle();
    	return !in_array( $oldVehiclesTitleForCurrentOperatingLevel, $this->newTitles );
    }
    
    function apply(VF_Vehicle $descendant)
    {
        $titles = $descendant->toTitleArray();
        
        $levelsToReplace = $this->getSchema()->getPrevLevelsIncluding($this->grain);
        foreach( $levelsToReplace as $levelToReplace )
        {
            $replacementTitle = $this->vehicle()->getLevel($levelToReplace)->getTitle();
            $titles[$levelToReplace] = $replacementTitle;
        }
    
        foreach($this->newTitles as $replacementTitle)
        {
            $titles[$this->grain] = $replacementTitle;
            $new_vehicle = VF_Vehicle::create($this->getSchema(), $titles);
            $new_vehicle->save();
            $this->mergeFitments($descendant, $new_vehicle);
        }
        
    }
    
    function vehicle()
    {
        if(!isset($this->vehicleObj))
        {
            $this->vehicleObj = $this->vehicleFinder()->findOneByLevelIds( $this->vehicleParams(), VF_Vehicle_Finder::INCLUDE_PARTIALS );
        }
        return $this->vehicleObj;        
    }
    
    function vehicleDescendants()
    {
        $this->vehicle();
        $descendants = $this->vehicleFinder()->findByLevelIds( $this->vehicleParams() );
        return $descendants;
    }
    
    function vehicleParams()
    {
        $params = $this->vehicle->levelIdsTruncateAfter($this->grain);
        return $params;
    }
    
    function operatingGrain()
    {
        return $this->grain;
    }
}