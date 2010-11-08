<?php
class Elite_Vaf_Model_Split extends Elite_Vaf_Model_Base
{
    /** @var Elite_Vaf_Model_Vehicle */
    protected $vehicle;
    protected $grain, $newTitles;
    
    function __construct( $vehicle, $grain, $newTitles )
    {
        $this->vehicle = $vehicle;
        $this->grain = $grain;
        $this->newTitles = $newTitles;
    }
    
    function execute()
    {
        $descendants = $this->vehicleDescendants();
        foreach($descendants as $descendant)
        {
            $this->apply($descendant);
        }
        $this->vehicle()->unlink();
    }
    
    function apply(Elite_Vaf_Model_Vehicle $descendant)
    {
        $titles = $descendant->toTitleArray();
        $levelsToReplace = $this->getSchema()->getPrevLevelsIncluding($this->grain);
        foreach( $levelsToReplace as $levelToReplace )
        {
            if($levelsToReplace != $this->grain)
            {
                $replacementTitle = $this->vehicle()->getLevel($levelToReplace)->getTitle();
                $titles[$levelToReplace] = $replacementTitle;
            }
        }
        
        foreach($this->newTitles as $replacementTitle)
        {
            $titles[$this->grain] = $replacementTitle;
            $new_vehicle = Elite_Vaf_Model_Vehicle::create($this->getSchema(), $titles);
            $new_vehicle->save();
        }
        
    }
    
    function vehicle()
    {
        return $this->vehicleFinder()->findOneByLevelIds( $this->vehicleParams(), Elite_Vaf_Model_Vehicle_Finder::EXACT_ONLY );
    }
    
    function vehicleDescendants()
    {
        $descendants = $this->vehicleFinder()->findByLevelIds( $this->vehicleParams() );
        return $descendants;
    }
    
    function vehicleParams()
    {
        $params = $this->vehicle->levelIdsTruncateAfter($this->grain);
        return $params;
    }
    
}