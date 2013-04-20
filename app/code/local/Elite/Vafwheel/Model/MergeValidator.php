<?php
class Elite_Vafwheel_Model_MergeValidator
{
	function ensureCompatible($slaveVehicles, $masterVehicle)
    {
    	$masterVehicle = new Elite_Vafwheel_Model_Vehicle($masterVehicle);
    	foreach($slaveVehicles as $slaveVehicle)
    	{
    		$slaveVehicle = new Elite_Vafwheel_Model_Vehicle($slaveVehicle);
	    	if( $masterVehicle->boltPattern() != $slaveVehicle->boltPattern() )
	    	{
	    		throw new Elite_Vaf_Model_Merge_Exception_IncompatibleVehicleAttribute('bolt patterns dont match');
	    	}
    	}
    }
}