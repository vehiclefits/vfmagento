<?php
class Elite_Vaf_Model_MergeTests_WheelsTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
	function testShouldAllowtOperation()
    {
        $vehicle1 = $this->createMMY('Honda','Civic','2000');
        $vehicle2 = $this->createMMY('Honda','Civic','2001');
        
        $wheelVehicle1 = new Elite_Vafwheel_Model_Vehicle($vehicle1);
        $wheelVehicle1->save();
        $wheelVehicle1->addBoltPattern( $this->boltPattern('4x114.3') );
        
        $wheelVehicle2 = new Elite_Vafwheel_Model_Vehicle($vehicle2);
        $wheelVehicle2->save();
        $wheelVehicle2->addBoltPattern( $this->boltPattern('4x114.3') );
        
        $slaveLevels = array(
            array('year', $vehicle1 ),
            array('year', $vehicle2 ),
        );
        $masterLevel = array('year', $vehicle2 );
        
        $this->merge($slaveLevels, $masterLevel);
    }
    
	/**
	 * @expectedException Elite_Vaf_Model_Merge_Exception_IncompatibleVehicleAttribute
	 */
	function testShouldPreventOperation()
    {
        $vehicle1 = $this->createMMY('Honda','Civic','2000');
        $vehicle2 = $this->createMMY('Honda','Civic','2001');
        
        $wheelVehicle1 = new Elite_Vafwheel_Model_Vehicle($vehicle1);
        $wheelVehicle1->save();
        $wheelVehicle1->addBoltPattern( $this->boltPattern('4x114.3') );
        
        $wheelVehicle2 = new Elite_Vafwheel_Model_Vehicle($vehicle2);
        $wheelVehicle2->save();
        $wheelVehicle2->addBoltPattern( $this->boltPattern('5x114') );
        
        $slaveLevels = array(
            array('year', $vehicle1 ),
            array('year', $vehicle2 ),
        );
        $masterLevel = array('year', $vehicle2 );
        
        $this->merge($slaveLevels, $masterLevel);
    }
}