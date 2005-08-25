<?php
class VF_Level_FinderTests_FindEntityIdByTitleGlobalTest extends Elite_Vaf_TestCase
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
    
    function testShouldNotRequireParentId()
    {
        $vehicle = $this->createVehicle(array('year'=>'2000', 'make'=>'Honda', 'model'=>'Civic'));
        $makeId = $this->levelFinder()->findEntityIdByTitle( 'make', 'Honda' );
        $this->assertEquals( $vehicle->getValue('make'), $makeId, 'should not require parent id for global level' );
    }

    function testShouldSearchUnderDifferentParentId()
    {
        $y2000 = $this->newYear('2000');
        $y2000->save();
        
        $y2001 = $this->newYear('2001');
        $y2001->save();
        
        $honda = $this->newMake('Honda');
        $honda->save($y2000->getId());
        
        $makeId = $this->levelFinder()->findEntityIdByTitle( 'make', 'Honda', $y2001->getId() );
        $this->assertEquals( $honda->getId(), $makeId, 'should search under different parent ids' );
    }

}