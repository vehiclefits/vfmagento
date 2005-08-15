<?php
class Elite_Vaf_Model_Vehicle_FinderTests_ByLevelsMMYETest extends Elite_Vaf_Model_Vehicle_FinderTests_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year,engine');
    }
    
    function testShouldFindExactPartial()
    {
	$vehicle = $this->createVehicle(array('make'=>'honda', 'model'=>'civic', 'year'=>'2000', 'engine'=>'1.0'));
	$vehicle = $this->getFinder()->findOneByLevels( array('make'=>'Honda'), Elite_Vaf_Model_Vehicle_Finder::EXACT_ONLY );
        $this->assertEquals(0, $vehicle->getValue('model'));
    }
}