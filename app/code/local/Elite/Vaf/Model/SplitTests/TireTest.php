<?php
class Elite_Vaf_Model_SplitTests_TireTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
	function testShouldDuplicateTire()
    {
        $vehicle = $this->createMMY('Honda','Civic','2000');
        $tireSize = Elite_Vaftire_Model_TireSize::create('205/55-16');
        
        $tireVehicle = new Elite_Vaftire_Model_Vehicle($vehicle);
        $tireVehicle->save();
        $tireVehicle->addTireSize( $tireSize );
        
        $this->split($vehicle, 'year', array('2000','2001'));
        
        $one = $this->vehicleFinder()->findOneByLevels(array('make'=>'Honda', 'model'=>'Civic', 'year'=>'2000'));
        $tireVehicle1 = new Elite_Vaftire_Model_Vehicle($one);
        
        $two = $this->vehicleFinder()->findOneByLevels(array('make'=>'Honda', 'model'=>'Civic', 'year'=>'2000'));
        $tireVehicle2 = new Elite_Vaftire_Model_Vehicle($two);
        
        $one = $tireVehicle1->tireSize();
        $two = $tireVehicle2->tireSize();
        $this->assertEquals( $tireSize, $one[0], 'SPLIT Should copy tire size to each resultant vehicle.' );
        $this->assertEquals( $tireSize, $two[0], 'SPLIT Should copy tire size to each resultant vehicle.' );
    }
    
}