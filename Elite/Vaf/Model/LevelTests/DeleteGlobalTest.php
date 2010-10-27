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
       
    /**
    * @expectedException Elite_Vaf_Model_Level_Exception_NotFound
    */
    function testWhenDeleteMakeShouldNotHaveChildren()
    {
        $originalHonda = $this->createMMY('Honda','Civic','2000');
        $year = $originalHonda->getLevel('year');
        $make = $originalHonda->getLevel('make');
        $model = $originalHonda->getLevel('model');
        
        $vehicles = $this->vehicleFinder()->findByLevelIds( array('year'=>$year->getId(), 'make'=>$make->getId(), 'model'=>0), true );
        $vehicles[0]->unlink();
        
        // should have deleted make
        $make = $this->levelFinder()->find('make', $make->getId());
    }
    
    function testWhenDeleteModelShouldRetainMake()
    {
        $originalHonda = $this->createMMY('Honda','Civic','2000');
        $year = $originalHonda->getLevel('year');
        $make = $originalHonda->getLevel('make');
        $model = $originalHonda->getLevel('model');
        
        $vehicles = $this->vehicleFinder()->findByLevelIds( array('year'=>$year->getId(), 'make'=>$make->getId(), 'model'=>$model->getId()), true );
        $vehicles[0]->unlink();
        
        $make2 = $this->levelFinder()->find('make', $make->getId());
        $this->assertEquals($make->getId(), $make2->getId(), 'when deleting model, should retain make');
    }
    
    function testWhenDeleteYearShouldNotHaveChildren()
    {
        $honda = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>2000));
        $honda->unlink();
        
        $make = $this->levelFinder()->find('make',$honda->getValue('make'));
        $this->assertEquals(0, $make->getChildCount());
    }
    
    function testShouldDeleteModel()
    {
        $honda = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>2000));
        $honda->unlink();
        $r = $this->getReadAdapter()->query("select count(*) from elite_level_model where title = 'Civic';");
        $this->assertEquals(0, $r->fetchColumn(), 'when unlinking a model, should delete that model' );
    }
    
    function testWhenUnlinkShouldNotDeleteYear()
    {
        $honda = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>2000));
        $honda->unlink();
        $r = $this->getReadAdapter()->query("select count(*) from elite_level_year where title = '2000';");
        $this->assertEquals(1, $r->fetchColumn(), 'should not delete year' );
    }
	
}