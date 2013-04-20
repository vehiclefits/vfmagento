<?php
class VF_Level_Finder_InserterTests_GlobalTest extends Elite_Vaf_TestCase
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
    }
    
    function tearDown()
    {
        $schemaGenerator = new VF_Schema_Generator();
        $schemaGenerator->dropExistingTables();
    }
    
    function testShouldBeAbleToSaveMakeWithNoParent()
    {
        $honda = $this->newMake('Honda');
        $honda->save();
        $this->assertEquals( $honda->getId(), $this->levelFinder()->findEntityIdByTitle('make', 'Honda'), 'should save make with no parent' );
    }
    
    function testShouldBeAbleToSaveMakeWithParent()
    {
        $y2000 = $this->newYear('2000');        
        $y2000->save();
        
        $honda = $this->newMake('Honda');
        $honda->save( $y2000->getId() );
        
        $this->assertEquals( $honda->getId(), $this->levelFinder()->findEntityIdByTitle('make', 'Honda'), 'should save make with parent');
    }
    
    function testShouldSaveMakeUnderMultipleYears()
    {
        $y2000 = $this->newYear('2000');        
        $y2000->save();
        
        $y2001 = $this->newYear('2001');        
        $y2001->save();
        
        $honda = $this->newMake('Honda');
        $honda->save( $y2000->getId() );
        
        $honda = $this->newMake('Honda');
        $honda->save( $y2001->getId() );
        
        $this->assertTrue( $this->vehicleExists(array('year'=>'2000', 'make'=>'Honda'), true) );
        $this->assertTrue( $this->vehicleExists(array('year'=>'2001', 'make'=>'Honda'), true) );
    } 
    
    function testShouldSaveMakeUnderSingleYear()
    {
        $y2000 = $this->newYear('2000');        
        $y2000->save();
        
        $y2001 = $this->newYear('2001');        
        $y2001->save();
        
        $honda = $this->newMake('Honda');
        $honda->save( $y2000->getId() );
        
        $this->assertFalse( $this->vehicleExists(array('year'=>'2001', 'make'=>'Honda'), true) );
    }

    function testShouldSaveModelUnderSingleYear()
    {
        $y2000 = $this->newYear('2000');        
        $y2000->save();
        
        $y2001 = $this->newYear('2001');        
        $y2001->save();
        
        $honda = $this->newMake('Honda');
        $honda->save( $y2000->getId() );
        
        $honda = $this->newMake('Honda');
        $honda->save( $y2001->getId() );
        
        $civic = $this->newModel('Civic');
        $civic->save($honda->getId());
        
        $this->assertTrue( $this->vehicleExists(array('year'=>'2000', 'make'=>'Honda','model'=>'Civic')) );
        $this->assertFalse( $this->vehicleExists(array('year'=>'2001', 'make'=>'Honda','model'=>'Civic')) );
    }

    function testShouldSaveModelUnderMultipleYears()
    {
        $y2000 = $this->newYear('2000');        
        $y2000->save();
        
        $y2001 = $this->newYear('2001');        
        $y2001->save();
        
        $honda = $this->newMake('Honda');
        $honda->save( $y2000->getId() );
        
        $honda = $this->newMake('Honda');
        $honda->save( $y2001->getId() );
        
        $civic = $this->newModel('Civic');
        $civic->save(array('year'=>$y2000->getId(), 'make'=>$honda->getId()));
        
        $civic = $this->newModel('Civic');
        $civic->save(array('year'=>$y2001->getId(), 'make'=>$honda->getId()));
        
        $this->assertTrue($this->vehicleExists(array('year'=>'2000', 'make'=>'Honda','model'=>'Civic')));
        $this->assertTrue($this->vehicleExists(array('year'=>'2001', 'make'=>'Honda','model'=>'Civic')));
    }
    
    function testModelsShouldBeYearSpecific()
    {
        $y2000 = $this->newYear('2000');        
        $y2000->save();
        
        $y2001 = $this->newYear('2001');        
        $y2001->save();
        
        $honda = $this->newMake('Honda');
        $honda->save( $y2000->getId() );
        
        $honda = $this->newMake('Honda');
        $honda->save( $y2001->getId() );
        
        $civic = $this->newModel('Civic');
        $civic->save(array('make'=>$honda->getId(), 'year'=>$y2000->getId()));
        
        $civic = $this->newModel('Accord');
        $civic->save(array('make'=>$honda->getId(), 'year'=>$y2001->getId()));
        
        $this->assertTrue($this->vehicleExists(array('year'=>'2000', 'make'=>'Honda','model'=>'Civic')));
        $this->assertFalse($this->vehicleExists(array('year'=>'2001', 'make'=>'Honda','model'=>'Civic')));
        
        $this->assertTrue($this->vehicleExists(array('year'=>'2001', 'make'=>'Honda','model'=>'Accord')));
        $this->assertFalse($this->vehicleExists(array('year'=>'2000', 'make'=>'Honda','model'=>'Accord')));
    }
}