<?php
class VF_Vehicle_FinderTests_MultipleSchemaTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testVehicleExists()
    {
        return $this->markTestIncomplete();
        
        $schema = VF_Schema::create('foo,bar');
        $finder = new VF_Vehicle_Finder($schema);
        $this->assertFalse($finder->vehicleExists(array('foo'=>'test','bar'=>'doesntexist')), 'vehicle should not exist');
    }
}