<?php
class Elite_Vaf_Model_LevelTests_UnlinkTest extends Elite_Vafimporter_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    /**
    * @expectedException Elite_Vaf_Model_Level_Exception_NotFound
    */
    function testWhenUnlinkMake_ShouldDeleteMake()
    {
        $originalHonda = $this->createMMY('Honda','Civic','2000');
        
        $make = $originalHonda->getLevel('make');
        
        $vehicles = $this->vehicleFinder()->findByLevelIds( array( 'make'=>$make->getId(), 'model'=>0, 'year'=>0), true );
        $vehicles[0]->unlink();
        
        $this->levelFinder()->find('make', $make->getId());
    }
        
    /**
    * @expectedException Elite_Vaf_Model_Level_Exception_NotFound
    */
    function testWhenUnlinkMake_ShouldDeleteMake_Imported()
    {
        $this->importVehiclesList('make,model,year' . "\n" . 
                                  'Honda,Civic,2000');
        
        $make = $this->findEntityByTitle('make', 'Honda');
        
        $vehicles = $this->vehicleFinder()->findByLevelIds( array( 'make'=>$make->getId(), 'model'=>0, 'year'=>0), true );
        $vehicles[0]->unlink();
        
        $this->levelFinder()->find('make', $make->getId());
    }
    
    /**
    * @expectedException Elite_Vaf_Model_Level_Exception_NotFound
    */
    function testWhenUnlinkMake_ShouldDeleteModel()
    {
        $originalHonda = $this->createMMY('Honda','Civic','2000');
        
        $make = $originalHonda->getLevel('make');
        $model = $originalHonda->getLevel('model');
        
        $vehicles = $this->vehicleFinder()->findByLevelIds( array( 'make'=>$make->getId(), 'model'=>0, 'year'=>0), true );
        $vehicles[0]->unlink();
        
        $this->levelFinder()->find('model', $model->getId());
    }
    
    /**
    * @expectedException Elite_Vaf_Model_Level_Exception_NotFound
    */
    function testWhenUnlinkMake_ShouldDeleteYear()
    {
        $originalHonda = $this->createMMY('Honda','Civic','2000');
        
        $make = $originalHonda->getLevel('make');
        $model = $originalHonda->getLevel('model');
        $year = $originalHonda->getLevel('year');
        
        $vehicles = $this->vehicleFinder()->findByLevelIds( array( 'make'=>$make->getId(), 'model'=>0, 'year'=>0), true );
        $vehicles[0]->unlink();
        
        $this->levelFinder()->find('year', $year->getId());
    }
    
    function testWhenUnlinkModel_ShouldRetainMake()
    {
        $originalHonda = $this->createMMY('Honda','Civic','2000');
        
        $make = $originalHonda->getLevel('make');
        $model = $originalHonda->getLevel('model');
        $year = $originalHonda->getLevel('year');
        
        $vehicles = $this->vehicleFinder()->findByLevelIds( array( 'make'=>$make->getId(), 'model'=>$model->getId(), 'year'=>0), true );
        $vehicles[0]->unlink();
        
        $newMake = $this->levelFinder()->find('make', $make->getId());
        $this->assertEquals( $make->getId(), $newMake->getId(), 'when unlink model, should retain make');
    }
    
    /**
    * @expectedException Elite_Vaf_Model_Level_Exception_NotFound
    */
    function testWhenUnlinkModel_ShouldDeleteModel()
    {
        $originalHonda = $this->createMMY('Honda','Civic','2000');
        
        $make = $originalHonda->getLevel('make');
        $model = $originalHonda->getLevel('model');
        
        $vehicles = $this->vehicleFinder()->findByLevelIds( array( 'make'=>$make->getId(), 'model'=>$model->getId(), 'year'=>0), true );
        $vehicles[0]->unlink();
                
        $this->levelFinder()->find('model', $model->getId());
    }
    
    /**
    * @expectedException Elite_Vaf_Model_Level_Exception_NotFound
    */
    function testWhenUnlinkModel_ShouldDeleteYear()
    {
        $originalHonda = $this->createMMY('Honda','Civic','2000');
        
        $make = $originalHonda->getLevel('make');
        $model = $originalHonda->getLevel('model');
        $year = $originalHonda->getLevel('year');
        
        $vehicles = $this->vehicleFinder()->findByLevelIds( array( 'make'=>$make->getId(), 'model'=>$model->getId(), 'year'=>0), true );
        $vehicles[0]->unlink();
                
        $this->levelFinder()->find('year', $year->getId());
    }
    
    function testWhenUnlinkYear_ShouldRetainMake()
    {
        $originalHonda = $this->createMMY('Honda','Civic','2000');
        
        $make = $originalHonda->getLevel('make');
        $model = $originalHonda->getLevel('model');
        $year = $originalHonda->getLevel('year');
        
        $vehicles = $this->vehicleFinder()->findByLevelIds( array( 'make'=>$make->getId(), 'model'=>$model->getId(), 'year'=>$year->getId()), true );
        $vehicles[0]->unlink();
        
        $newMake = $this->levelFinder()->find('make', $make->getId());
        $this->assertEquals( $make->getId(), $newMake->getId(), 'when unlink model, should retain make');
    }
    
    function testWhenUnlinkYear_ShouldRetainModel()
    {
        $originalHonda = $this->createMMY('Honda','Civic','2000');
        
        $make = $originalHonda->getLevel('make');
        $model = $originalHonda->getLevel('model');
        $year = $originalHonda->getLevel('year');
        
        $vehicles = $this->vehicleFinder()->findByLevelIds( array( 'make'=>$make->getId(), 'model'=>$model->getId(), 'year'=>$year->getId()), true );
        $vehicles[0]->unlink();
        
        $newModel = $this->levelFinder()->find('model', $model->getId());
        $this->assertEquals( $model->getId(), $newModel->getId(), 'when unlink model, should retain model');
    }
    
    /**
    * @expectedException Elite_Vaf_Model_Level_Exception_NotFound
    */
    function testWhenUnlinkYear_ShouldDeleteYear()
    {
        $originalHonda = $this->createMMY('Honda','Civic','2000');
        
        $make = $originalHonda->getLevel('make');
        $model = $originalHonda->getLevel('model');
        $year = $originalHonda->getLevel('year');
        
        $vehicles = $this->vehicleFinder()->findByLevelIds( array( 'make'=>$make->getId(), 'model'=>$model->getId(), 'year'=>$year->getId()), true );
        $vehicles[0]->unlink();
        
        $this->levelFinder()->find('year', $year->getId(), 'when unlink year should delete year');
    }

    function testShouldDeleteFitments()
    {
        $originalHonda = $this->createMMY('Honda','Civic','2000');
        $this->insertMappingMMY($originalHonda,1);
        
        $make = $originalHonda->getLevel('make');
        $model = $originalHonda->getLevel('model');
        $year = $originalHonda->getLevel('year');
        
        $vehicles = $this->vehicleFinder()->findByLevelIds( array( 'make'=>$make->getId(), 'model'=>$model->getId(), 'year'=>$year->getId()), true );
        $vehicles[0]->unlink();
        
        $this->assertEquals(0,$this->getReadAdapter()->query('select count(*) from elite_mapping')->fetchColumn( ));
    }
}