<?php
class Elite_Vafpaint_Model_MergeValidator
{
 	function ensureCompatible($slaveVehicles, $masterVehicle)
    {
    	$paintMapper = new Elite_Vafpaint_Model_Paint_Mapper;
    	$paints = $paintMapper->findByFitId($masterVehicle->getLeafValue());
    	if(count($paints))
    	{
    		throw new Elite_Vaf_Model_Merge_Exception_IncompatibleVehicleAttribute('vehicles have paint codes');
    	}
    	foreach($slaveVehicles as $slaveVehicle)
    	{
	    	$paints = $paintMapper->findByFitId($slaveVehicle->getLeafValue());
    		if(count($paints))
	    	{
	    		throw new Elite_Vaf_Model_Merge_Exception_IncompatibleVehicleAttribute('vehicles have paint codes');
	    	}
    	}
    }
}