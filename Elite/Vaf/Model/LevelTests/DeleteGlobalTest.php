<?php
class Elite_Vaf_Model_LevelTests_DeleteGlobalTest extends Elite_Vaf_TestCase
{
	function doSetUp()
    {
        $schemaGenerator = new Elite_Vaf_Model_Schema_Generator();
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
        $schemaGenerator = new Elite_Vaf_Model_Schema_Generator();
        $schemaGenerator->dropExistingTables();
    }
    
    function testShouldUnlinkYear()
    {
        $acura = $this->createVehicle(array('make'=>'Acura', 'model'=>'Integra', 'year'=>2000));
        $acura->unlink();
        $this->assertFalse( $this->vehicleExists(array('make'=>'Acura', 'model'=>'Integra', 'year'=>2000)), 'should unlink year' );
    }
    
    function testShouldNotUnlinkYearFromOtherMake()
    {
        $honda = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>2000));
        $acura = $this->createVehicle(array('make'=>'Acura', 'model'=>'Integra', 'year'=>2000));
        
        $acura->unlink();
        $this->assertTrue( $this->vehicleExists(array('make'=>'Honda', 'model'=>'Civic', 'year'=>2000)), 'should not unlink honda/2000 when unlinking acura/2000' );
    }
    
    function testShouldUnlinkModel()
    {
        $honda = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>2000));
        $honda->unlink();
        $r = $this->getReadAdapter()->query("select count(*) from elite_level_model where title = 'Civic';");
        $this->assertEquals(0, $r->fetchColumn(), 'when unlinking a model, should delete that model' );
    }
	
	
}