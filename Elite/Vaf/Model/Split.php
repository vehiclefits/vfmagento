<?php
class Elite_Vaf_Model_Split extends Elite_Vaf_Model_Base
{
    /** @var Elite_Vaf_Model_Vehicle */
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
        foreach($descendants as $descendant)
        {
            $this->apply($descendant);
        }
        if(count($descendants) && $this->shouldDeleteOldVehicle()  )
        {
            $this->vehicle()->unlink();
        }
    }
    
    function shouldDeleteOldVehicle()
    {
    	$oldVehiclesTitleForCurrentOperatingLevel = $this->vehicle()->getLevel($this->grain)->getTitle();
    	return !in_array( $oldVehiclesTitleForCurrentOperatingLevel, $this->newTitles );
    }
    
    function apply(Elite_Vaf_Model_Vehicle $descendant)
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
            $new_vehicle = Elite_Vaf_Model_Vehicle::create($this->getSchema(), $titles);
            $new_vehicle->save();
            $this->mergeFitments($descendant, $new_vehicle);
        }
        
    }
    
    function vehicle()
    {
        if(!isset($this->vehicleObj))
        {
            $this->vehicleObj = $this->vehicleFinder()->findOneByLevelIds( $this->vehicleParams(), Elite_Vaf_Model_Vehicle_Finder::EXACT_ONLY );
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