<?php
class Elite_Vaf_Model_LevelTests_UnlinkTest extends Elite_Vafimporter_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testWhenUnlinkMake_ShouldDeleteMake()
    {
        $originalVehicle = $this->createMMY('Honda','Civic','2000');
        $makeId = $originalVehicle->getValue('make');
        
        $params = array(
            'make' => $makeId,
            'model'=> 0,
            'year' => 0
        );
        
        $this->vehicleFinder()->findOneByLevelIds( $params, true )->unlink();
        
        $this->assertFalse( $this->levelExists('make', $makeId), 'when unlink make should delete make');
    }
        
    function testWhenUnlinkMake_ShouldDeleteMake_Imported()
    {
        $this->importVehiclesList('make,model,year' . "\n" . 
                                  'Honda,Civic,2000');
        
        $makeId = $this->findEntityIdByTitle('Honda','make');
        
        $params = array(
            'make' => $makeId,
            'model'=> 0,
            'year' => 0
        );
        $this->vehicleFinder()->findOneByLevelIds( $params, true )->unlink();
        
        $this->assertFalse( $this->levelExists('make', $makeId), 'when unlink make, should delete make (from import)');
    }
    
    function testWhenUnlinkMake_ShouldDeleteModel()
    {
        $originalVehicle = $this->createMMY('Honda','Civic','2000');
        $makeId = $originalVehicle->getValue('make');
        
        $params = array(
            'make' => $makeId,
            'model'=> 0,
            'year' => 0
        );
        $vehicle = $this->vehicleFinder()->findOneByLevelIds( $params, true )->unlink();
        
        $modelId = $originalVehicle->getValue('model');
        $this->assertFalse( $this->levelExists('model', $modelId), 'when unlink make, should delete model');
    }
    
    function testWhenUnlinkMake_ShouldDeleteYear()
    {
        $originalHonda = $this->createMMY('Honda','Civic','2000');
        
        $make = $originalHonda->getLevel('make');
        $model = $originalHonda->getLevel('model');
        $year = $originalHonda->getLevel('year');
        
        $vehicle = $this->vehicleFinder()->findOneByLevelIds( array( 'make'=>$make->getId(), 'model'=>0, 'year'=>0), true );
        $vehicle->unlink();
        
        $this->assertFalse( $this->levelExists('year', $year->getId()), 'when unlink make, should delete year');
    }
    
    function testWhenUnlinkModel_ShouldRetainMake()
    {
        $originalHonda = $this->createMMY('Honda','Civic','2000');
        
        $make = $originalHonda->getLevel('make');
        $model = $originalHonda->getLevel('model');
        $year = $originalHonda->getLevel('year');
        
        $vehicle = $this->vehicleFinder()->findOneByLevelIds( array( 'make'=>$make->getId(), 'model'=>$model->getId(), 'year'=>0), true );
        $vehicle->unlink();
        
        $this->assertTrue( $this->levelExists('make', $make->getId()), 'when unlink model, should retain make');
    }
    
    function testWhenUnlinkModel_ShouldDeleteModel()
    {
        $originalHonda = $this->createMMY('Honda','Civic','2000');
        
        $make = $originalHonda->getLevel('make');
        $model = $originalHonda->getLevel('model');
        
        $vehicle = $this->vehicleFinder()->findOneByLevelIds( array( 'make'=>$make->getId(), 'model'=>$model->getId(), 'year'=>0), true );
        $vehicle->unlink();
                
        $this->assertFalse( $this->levelExists('model', $model->getId()) );
    }
    
    function testWhenUnlinkModel_ShouldDeleteYear()
    {
        $originalHonda = $this->createMMY('Honda','Civic','2000');
        
        $make = $originalHonda->getLevel('make');
        $model = $originalHonda->getLevel('model');
        $year = $originalHonda->getLevel('year');
        
        $vehicle = $this->vehicleFinder()->findOneByLevelIds( array( 'make'=>$make->getId(), 'model'=>$model->getId(), 'year'=>0), true );
        $vehicle->unlink();
                
        $this->assertFalse( $this->levelExists('year', $year->getId()), 'when unlink model, should delete year');
    }
    
    function testWhenUnlinkYear_ShouldRetainMake()
    {
        $originalHonda = $this->createMMY('Honda','Civic','2000');
        
        $make = $originalHonda->getLevel('make');
        $model = $originalHonda->getLevel('model');
        $year = $originalHonda->getLevel('year');
        
        $vehicle = $this->vehicleFinder()->findOneByLevelIds( array( 'make'=>$make->getId(), 'model'=>$model->getId(), 'year'=>$year->getId()), true );
        $vehicle->unlink();
        
        $this->assertTrue( $this->levelExists('make', $make->getId()), 'when unlink model, should retain make');
    }
    
    function testWhenUnlinkYear_ShouldRetainModel()
    {
        $originalHonda = $this->createMMY('Honda','Civic','2000');
        
        $make = $originalHonda->getLevel('make');
        $model = $originalHonda->getLevel('model');
        $year = $originalHonda->getLevel('year');
        
        $vehicle = $this->vehicleFinder()->findOneByLevelIds( array( 'make'=>$make->getId(), 'model'=>$model->getId(), 'year'=>$year->getId()), true );
        $vehicle->unlink();
        
        $this->assertTrue( $this->levelExists('model', $model->getId()), 'when unlink model, should retain model');
    }
    
    function testWhenUnlinkYear_ShouldDeleteYear()
    {
        $originalHonda = $this->createMMY('Honda','Civic','2000');
        
        $make = $originalHonda->getLevel('make');
        $model = $originalHonda->getLevel('model');
        $year = $originalHonda->getLevel('year');
        
        $vehicle = $this->vehicleFinder()->findOneByLevelIds( array( 'make'=>$make->getId(), 'model'=>$model->getId(), 'year'=>$year->getId()), true );
        $vehicle->unlink();
        
        $this->assertFalse( $this->levelExists('year', $year->getId()), 'when unlink year should delete year');
    }

    function testShouldDeleteFitments()
    {
        $originalHonda = $this->createMMY('Honda','Civic','2000');
        $this->insertMappingMMY($originalHonda,1);
        
        $make = $originalHonda->getLevel('make');
        $model = $originalHonda->getLevel('model');
        $year = $originalHonda->getLevel('year');
        
        $vehicle = $this->vehicleFinder()->findOneByLevelIds( array( 'make'=>$make->getId(), 'model'=>$model->getId(), 'year'=>$year->getId()), true );
        $vehicle->unlink();
        
        $this->assertEquals(0,$this->getReadAdapter()->query('select count(*) from elite_mapping')->fetchColumn( ));
    }
    
    function levelExists($level,$id)
    {
        try
        {
            $this->levelFinder()->find($level, $id);
        }
        catch( Elite_Vaf_Model_Level_Exception_NotFound $e )
        {
            return false;
        }
        return true;
    }
}