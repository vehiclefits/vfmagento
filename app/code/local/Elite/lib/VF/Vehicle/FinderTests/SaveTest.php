<?php
class VF_Vehicle_FinderTests_SaveTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $schemaGenerator = new VF_Schema_Generator();
        $schemaGenerator->dropExistingTables();
        $schemaGenerator->execute(array(
            'year',
            'make' => array('global'=>true),
            'model'
        ));
        $this->startTransaction();
    }
    
    function doTearDown()
    {
        $schemaGenerator = new VF_Schema_Generator();
        $schemaGenerator->dropExistingTables();
    }
    
    function testMakeShouldBeGlobal()
    {
        $vehicle1 = $this->createVehicle(array('year'=>'2000', 'make'=>'Honda', 'model'=>'Civic'));
        $vehicle2 = $this->createVehicle(array('year'=>'2001', 'make'=>'Honda', 'model'=>'Civic'));
        $this->assertEquals($vehicle1->getValue('make'), $vehicle2->getValue('make'), 'make should not be unique');
    }
        
    function testShouldPutMakeUnderFirstSavedYear()
    {
        $vehicle1 = $this->createVehicle(array('year'=>'2000', 'make'=>'Honda', 'model'=>'Civic'));
        $this->assertTrue( $this->vehicleExists(array('year'=>'2000', 'make'=>'Honda')), 'should put make "under" first saved year');
    }
            
    function testShouldPutMakeUnderSecondSavedYear()
    {
        $vehicle1 = $this->createVehicle(array('year'=>'2000', 'make'=>'Honda', 'model'=>'Civic'));
        $vehicle2 = $this->createVehicle(array('year'=>'2001', 'make'=>'Honda', 'model'=>'Civic'));
        $this->assertTrue( $this->vehicleExists(array('year'=>'2001', 'make'=>'Honda')), 'should put make "under" second saved year');
    }
    
    function testShouldNotPutMakeUnderWrongYears()
    {
        $vehicle1 = $this->createVehicle(array('year'=>'2000', 'make'=>'Honda', 'model'=>'Civic'));
        $vehicle2 = $this->createVehicle(array('year'=>'2001', 'make'=>'Honda', 'model'=>'Civic'));
        $vehicle3 = $this->createVehicle(array('year'=>'2002', 'make'=>'Acura', 'model'=>'Integra'));
        
        $this->assertFalse( $this->vehicleExists(array('year'=>'2002', 'make'=>'Honda')), 'should not put make "under" wrong years');
    }
    
    function testShouldNotPutModelUnderWrongYears()
    {
        $vehicle1 = $this->createVehicle(array('year'=>'2000', 'make'=>'Honda', 'model'=>'Civic'));
        $vehicle2 = $this->createVehicle(array('year'=>'2001', 'make'=>'Honda', 'model'=>'Accord'));
        
        $this->assertFalse( $this->vehicleExists(array('year'=>'2001', 'make'=>'Honda', 'model'=>'Civic')), 'should not put model "under" wrong years');
    }
}