<?php
class Elite_Vaf_Model_MergeTests_TireTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
	function testShouldAllowOperation()
    {
        $vehicle1 = $this->createTireMMY('Honda','Civic','2000');
        $vehicle1->addTireSize( Elite_Vaftire_Model_TireSize::create('205/55-16') );
        
        $vehicle2 = $this->createTireMMY('Honda','Civic','2001');
        $vehicle2->addTireSize( Elite_Vaftire_Model_TireSize::create('205/55-16') );
        
        $slaveLevels = array(
            array('year', $vehicle1->vehicle() ),
            array('year', $vehicle2->vehicle() ),
        );
        $masterLevel = array('year', $vehicle2->vehicle() );
        
        $this->merge($slaveLevels, $masterLevel);
    }
    
	/**
	 * @expectedException Elite_Vaf_Model_Merge_Exception_IncompatibleVehicleAttribute
	 */
	function testShouldPreventOperation()
    {
        $vehicle1 = $this->createTireMMY('Honda','Civic','2000');
        $vehicle1->addTireSize( Elite_Vaftire_Model_TireSize::create('205/55-16') );
        
        $vehicle2 = $this->createTireMMY('Honda','Civic','2001');
        $vehicle2->addTireSize( Elite_Vaftire_Model_TireSize::create('205/55-17') );
        
        $slaveLevels = array(
            array('year', $vehicle1->vehicle() ),
            array('year', $vehicle2->vehicle() ),
        );
        $masterLevel = array('year', $vehicle2->vehicle() );
        
        $this->merge($slaveLevels, $masterLevel);
    }
    
	/**
	 * @expectedException Elite_Vaf_Model_Merge_Exception_IncompatibleVehicleAttribute
	 */
	function testShouldPreventOperation2()
    {
        $vehicle1 = $this->createTireMMY('Honda','Civic','2000');
        $vehicle1->addTireSize( Elite_Vaftire_Model_TireSize::create('205/55-16') );
        
        $vehicle2 = $this->createTireMMY('Honda','Civic','2001');
        $vehicle2->addTireSize( Elite_Vaftire_Model_TireSize::create('205/56-16') );
        
        $slaveLevels = array(
            array('year', $vehicle1->vehicle() ),
            array('year', $vehicle2->vehicle() ),
        );
        $masterLevel = array('year', $vehicle2->vehicle() );
        
        $this->merge($slaveLevels, $masterLevel);
    }
    
	/**
	 * @expectedException Elite_Vaf_Model_Merge_Exception_IncompatibleVehicleAttribute
	 */
	function testShouldPreventOperation3()
    {
        $vehicle1 = $this->createTireMMY('Honda','Civic','2000');
        $vehicle1->addTireSize( Elite_Vaftire_Model_TireSize::create('205/55-16') );
        
        $vehicle2 = $this->createTireMMY('Honda','Civic','2001');
        $vehicle2->addTireSize( Elite_Vaftire_Model_TireSize::create('204/55-16') );
        
        $slaveLevels = array(
            array('year', $vehicle1->vehicle() ),
            array('year', $vehicle2->vehicle() ),
        );
        $masterLevel = array('year', $vehicle2->vehicle() );
        
        $this->merge($slaveLevels, $masterLevel);
    }
}