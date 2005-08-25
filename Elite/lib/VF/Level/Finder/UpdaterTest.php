<?php
class VF_Level_Finder_UpdaterTest extends Elite_Vaf_TestCase
{
    const PARENT_ID = 1;
    
    function testSaveLevelWithParent()
    {
        $model = new VF_Level('model');
        $model->setTitle('Civic');
        $model->save(self::PARENT_ID);
        $model = $this->findEntityById( $model->getId(), $model->getType(), self::PARENT_ID );
        
        $model->setTitle('Accord');
        $model->save(self::PARENT_ID);
        $model = $this->findEntityById( $model->getId(), $model->getType(), self::PARENT_ID );
        
        $this->assertSame( 'Accord', $model->getTitle(), 'saved entity should have correct title value' );
    }
    
    function testSaveRootLevel()
    {
        $make = new VF_Level('make');
        $make->setTitle('Honda');
        $make = $this->saveAndReload( $make );
        
        $make->setTitle('Acura');
        $make = $this->saveAndReload( $make );
        
        $this->assertSame('Acura', $make->getTitle(), 'saved entity should have correct title value' );
    }

}