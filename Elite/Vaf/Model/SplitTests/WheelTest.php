<?php
class Elite_Vaf_Model_SplitTests_WheelsTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
	function testShouldDuplicateWheel()
    {
        $vehicle = $this->createMMY('Honda','Civic','2000');
        
        $wheelVehicle = new Elite_Vafwheel_Model_Vehicle($vehicle);
        $wheelVehicle->save();
        $wheelVehicle->addBoltPattern( $this->boltPattern('4x114.3') );
        
        $this->split($vehicle, 'year', array('2000','2001'));
        
        $one = $this->vehicleFinder()->findOneByLevels(array('make'=>'Honda', 'model'=>'Civic', 'year'=>'2000'));
        $wheelVehicle1 = new Elite_Vafwheel_Model_Vehicle($one);
        
        $two = $this->vehicleFinder()->findOneByLevels(array('make'=>'Honda', 'model'=>'Civic', 'year'=>'2000'));
        $wheelVehicle2 = new Elite_Vafwheel_Model_Vehicle($two);
        
        $this->assertEquals( 4, $wheelVehicle1->boltPattern()->lug_count, 'SPLIT Should copy wheel (bolt pattern) to each resultant vehicle.' );
        $this->assertEquals( 114.3, $wheelVehicle1->boltPattern()->bolt_distance, 'SPLIT Should copy wheel (bolt pattern) to each resultant vehicle.' );
        
        $this->assertEquals( 4, $wheelVehicle2->boltPattern()->lug_count, 'SPLIT Should copy wheel (bolt pattern) to each resultant vehicle.' );
        $this->assertEquals( 114.3, $wheelVehicle2->boltPattern()->bolt_distance, 'SPLIT Should copy wheel (bolt pattern) to each resultant vehicle.' );
    }
    
}