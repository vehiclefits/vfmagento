<?php
class Elite_Vafimporter_Model_VehiclesList_Xml_Import
{
    protected $file;
    
    function __construct( $file )
    {
        $this->file = $file;
    }
    
    function import()
    {
        $xmlDocument = simplexml_load_file($this->file);
        
        foreach( $xmlDocument->definition as $vehicleInput )
        {
            $parent_id = 0;
            foreach($this->schema()->getLevels() as $level )
            {
                $levelObj = new Elite_Vaf_Model_Level($level);
                $levelObj->setTitle((string)$vehicleInput->$level);
                
                $attributes = $vehicleInput->$level->attributes();
                $id = (int)$attributes['id'];
                $parent_id = $levelObj->save($parent_id,$id);
            }
            $this->saveDefinition($vehicleInput);
        }
    }
    
    function saveDefinition($vehicleInputArray)
    {        
        $vehicleInputArray = (array)$vehicleInputArray;
        unset($vehicleInputArray['@attributes']);
        $vehicle = Elite_Vaf_Model_Vehicle::create($this->schema(),$vehicleInputArray);
        $vehicle->save();
    }
    
    function schema()
    {
        return new Elite_Vaf_Model_Schema();
    }
}