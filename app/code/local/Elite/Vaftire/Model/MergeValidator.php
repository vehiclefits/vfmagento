<?php
class Elite_Vaftire_Model_MergeValidator
{
 	function ensureCompatible($slaveVehicles, $masterVehicle)
    {
    	$masterVehicle = new Elite_Vaftire_Model_Vehicle($masterVehicle);
    	foreach($slaveVehicles as $slaveVehicle)
    	{
    		$slaveVehicle = new Elite_Vaftire_Model_Vehicle($slaveVehicle);
	    	if( $masterVehicle->tireSize() != $slaveVehicle->tireSize() )
	    	{
	    		throw new Elite_Vaf_Model_Merge_Exception_IncompatibleVehicleAttribute('tire sizes dont match');
	    	}
    	}
    }
}