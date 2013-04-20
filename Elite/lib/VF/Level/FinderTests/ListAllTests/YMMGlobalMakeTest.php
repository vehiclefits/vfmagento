<?php
class VF_Level_FinderTests_ListAllTests_YMMGlobalMakeTest extends Elite_Vaf_TestCase
{
    protected function doSetUp()
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
    
    /**
    * @expectedException VF_Level_Exception_InvalidLevel
    */
    function testShouldThrowExceptionForInvalidLevel()
    {
        $this->levelFinder()->listAll('model', array('foo'=>'bar'));
    }
    
    /**
    * @expectedException VF_Level_Exception_InvalidLevel
    */
    function testShouldThrowExceptionForInvalidLevel2()
    {
        $this->levelFinder()->listAll('model', array('bar'));
    }
    
    function testsShouldUseCommonMakeID()
    {
        $y2000 = $this->newYear('2000');
        $y2000->save();
        $y2001 = $this->newYear('2001');
        $y2001->save();
        
        $honda1 = $this->newMake('Honda');
        $honda1->save(array('year'=>$y2000->getId()));
        
        $honda2 = $this->newMake('Honda');
        $honda2->save(array('year'=>$y2001->getId()));
        
        $this->assertEquals( $honda1->getId(), $honda2->getId());
    }
        
    function testsShouldUseCommonModelID()
    {
        $y2000 = $this->newYear('2000');
        $y2000->save();
        $y2001 = $this->newYear('2001');
        $y2001->save();
        
        $honda = $this->newMake('Honda');
        $honda->save(array('year'=>$y2000->getId()));
        
        $honda = $this->newMake('Honda');
        $honda->save(array('year'=>$y2001->getId()));
        
        $civic1 = $this->newModel('Civic');
        $civic1->save(array('year'=>$y2000->getId(), 'make'=>$honda->getId()));
        
        $civic2 = $this->newModel('Civic');
        $civic2->save(array('year'=>$y2001->getId(), 'make'=>$honda->getId()));
        
        $this->assertEquals( $civic1->getId(), $civic2->getId(), 'should use common model IDs within "Honda" regardless of the year selected');
    }
        
    function testsShouldInsertDefinition()
    {
        $y2000 = $this->newYear('2000');
        $y2000->save();
        
        $honda1 = $this->newMake('Honda');
        $honda1->save(array('year'=>$y2000->getId()));
        
        $this->assertTrue( $this->vehicleExists(array('year'=>'2000', 'make'=>'Honda'),true) );
    }
       
    function testListDistinctMakes()
    {
        $vehicle1 = $this->createVehicle(array('year'=>2000, 'make'=>'Honda', 'model'=>'Civic'));
        $vehicle2 = $this->createVehicle(array('year'=>2001, 'make'=>'Honda', 'model'=>'Base'));
        
        $actual = $this->levelFinder()->listAll('make', array('year'=>$vehicle1->getValue('year')) );
        $this->assertEquals( 1, count($actual), 'should list distinct makes' );
    }
        
    function testListAllModels_ForAllYears_SpecificMake()
    {
        $vehicle1 = $this->createVehicle(array('year'=>2000, 'make'=>'Honda', 'model'=>'Civic'));
        $vehicle2 = $this->createVehicle(array('year'=>2001, 'make'=>'Honda', 'model'=>'Base'));
        
        $actual = $this->levelFinder()->listAll('model', $vehicle1->getValue('make'));
        $this->assertEquals( 2, count($actual), 'should list models for specific make, all years' );
    }
    
    function testListModelsFor_SpecificYear_SpecificMake()
    {
        $vehicle1 = $this->createVehicle(array('year'=>2000, 'make'=>'Honda', 'model'=>'Civic'));
        $vehicle2 = $this->createVehicle(array('year'=>2001, 'make'=>'Honda', 'model'=>'Base'));
        
        $params = array(
            'year'=>$vehicle1->getValue('year'),
            'make'=>$vehicle1->getValue('make')
        );
        $actual = $this->levelFinder()->listAll('model', $params);
        $this->assertEquals( 1, count($actual), 'should list models for specific year & make' );
    }
}