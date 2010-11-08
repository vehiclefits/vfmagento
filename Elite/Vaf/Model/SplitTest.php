<?php
class Elite_Vaf_Model_SplitTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testShouldSplitModel()
    {
        $vehicle = $this->createMMY('Ford','F-150/F-250','2000');
        $this->split($vehicle, 'model', array('F-150', 'F-250'));
        
        $this->assertTrue( $this->vehicleExists(array('make'=>'Ford','model'=>'F-150','year'=>2000)) );
        $this->assertTrue( $this->vehicleExists(array('make'=>'Ford','model'=>'F-250','year'=>2000)) );
        $this->assertFalse( $this->vehicleExists(array('make'=>'Ford','model'=>'F-150/F-250','year'=>2000)), 'should delete old vehicle' );
    }
        
    function testShouldSplitModel_MultipleYears()
    {
        $this->createMMY('Ford','F-150/F-250','2001');
        $vehicle = $this->createMMY('Ford','F-150/F-250','2000');
        
        $this->split($vehicle, 'model', array('F-150', 'F-250'));
        
        $this->assertTrue( $this->vehicleExists(array('make'=>'Ford','model'=>'F-150','year'=>2000)) );
        $this->assertTrue( $this->vehicleExists(array('make'=>'Ford','model'=>'F-150','year'=>2001)) );
        $this->assertTrue( $this->vehicleExists(array('make'=>'Ford','model'=>'F-250','year'=>2000)) );
        $this->assertTrue( $this->vehicleExists(array('make'=>'Ford','model'=>'F-250','year'=>2001)) );
        $this->assertFalse( $this->vehicleExists(array('make'=>'Ford','model'=>'F-150/F-250','year'=>2000)), 'should delete old vehicle' );
        $this->assertFalse( $this->vehicleExists(array('make'=>'Ford','model'=>'F-150/F-250','year'=>2001)), 'should delete old vehicle' );
    }
    
    function testShouldSplitMake()
    {
        $vehicle = $this->createMMY('Ford/Ford 2','F-150','2000');
        
        $this->split($vehicle, 'make', array('Ford','Ford 2'));
        
        $this->assertTrue( $this->vehicleExists(array('make'=>'Ford','model'=>'F-150','year'=>2000)) );
        $this->assertTrue( $this->vehicleExists(array('make'=>'Ford 2','model'=>'F-150','year'=>2000)) );
    }
    
    function split($vehicle, $grain, $newTitles)
    {
        $merge = new Elite_Vaf_Model_Split($vehicle, $grain, $newTitles);
        $merge->execute();
    }
}