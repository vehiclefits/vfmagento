<?php
class VF_Level_FinderTests_ListAllGlobalTest extends Elite_Vaf_TestCase
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
    
    function testListAllObeysParentIdForMake()
    {
        $y2000 = $this->newYear('2000');
        $y2000->save();
        
        $honda = $this->newMake('Honda');
        $honda->save($y2000);
        
        $y2001 = $this->newYear('2001');
        $y2001->save();
        
        $make = new VF_Level('make');
        $this->assertEquals( 0, count($make->listAll($y2001->getId())), 'list all should not find items from different parent id even in global mode' ); 
    }
    
    function testListAllObeysParentIdForModel()
    {
        $y2000 = $this->newYear('2000');
        $y2000->save();
        
        $y2001 = $this->newYear('2001');
        $y2001->save();
        
        $honda = $this->newMake('Honda');
        $honda->save($y2000);
        
        $honda = $this->newMake('Honda');
        $honda->save($y2001);
        
        $civic = $this->newModel('Civic');
        $civic->save($honda->getId());
        
        
        $model = new VF_Level('model');
        $models = $model->listAll(array('year'=>$y2000->getId(), 'make'=>$honda->getId()));
        $this->assertEquals( 0, count($models), 'list all should not find items from different parent id even in global mode' ); 
    }
    
}