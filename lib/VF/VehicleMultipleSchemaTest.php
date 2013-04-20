<?php
class VF_VehicleMultipleSchemaTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testSaveParenetheses()
    {
        return $this->markTestIncomplete();
        
        $schema = VF_Schema::create('foo,bar');
        
        $vehicle = VF_Vehicle::create($schema, array('foo'=>'valfoo','bar'=>'valbar'));
	$vehicle->save();
        
        $this->assertTrue($this->vehicleExists(array('foo'=>'valfoo','bar'=>'valbar')), 'should find vehicles in different schema' );
    }
    
}