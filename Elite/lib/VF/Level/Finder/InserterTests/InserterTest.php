<?php
class VF_Level_Finder_InserterTests_InserterTest extends Elite_Vaf_TestCase
{
    const PARENT_ID = 1;
    
    function testSaveLevelWithParent()
    {
        $model = new VF_Level('model');
        $model->setTitle( self::ENTITY_TITLE );
        $model->save(self::PARENT_ID);
        $model = $this->findEntityById( $model->getId(), $model->getType(), self::PARENT_ID );
        $this->assertSame( self::ENTITY_TITLE, $model->getTitle(), 'saved entity should have correct title value' );
    }

    function testSaveSetsMakeId()
    {
        $make = new VF_Level('make');
        $make->setTitle( self::ENTITY_TITLE );
        $make->save();
        $this->assertNotEquals( 0, $make->getId(), 'saved entity should have an id value' );
    }
    
    function testSaveSetsMakeId2()
    {
        $make = new VF_Level('make');
        $make->setTitle( self::ENTITY_TITLE );
        $make->save(array());
        $this->assertNotEquals( 0, $make->getId(), 'saved entity should have an id value' );
    }

    function testSaveSetsModelId()
    {
        $model = new VF_Level('model');
        $model->setTitle( self::ENTITY_TITLE );
        $model->save(self::PARENT_ID);
        $model = $this->findEntityById( $model->getId(), $model->getType(), self::PARENT_ID );
        $this->assertNotEquals( 0, $model->getId(), 'saved entity should have an id value' );
    }

    function testSaveSetsModelId2()
    {
        $model = new VF_Level('model');
        $model->setTitle( self::ENTITY_TITLE );
        $model->save(array('make'=>self::PARENT_ID));
        $model = $this->findEntityById( $model->getId(), $model->getType(), self::PARENT_ID );
        $this->assertNotEquals( 0, $model->getId(), 'saved entity should have an id value' );
    }
    
    function testSaveIsRepeatable()
    {
        $vehicle = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>2000));
        
        $model = new VF_Level('model');
        $model->setTitle('Civic');
        $model->save( $vehicle->getValue('make') );
        
        $this->assertEquals( $vehicle->getValue('model'), $model->getId(), 'saving multiple times should keep the same id' );
    }
    
    function testSaveRootLevel()
    {
        $make = new VF_Level('make');
        $make->setTitle( self::ENTITY_TITLE );
        $make = $this->saveAndReload( $make );
        $this->assertNotEquals( 0, $make->getId(), 'saved entity should have an id value' );
        $this->assertSame( self::ENTITY_TITLE, $make->getTitle(), 'saved entity should have correct title value' );
    }

}