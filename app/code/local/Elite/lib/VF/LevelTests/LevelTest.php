<?php
class VF_LevelTests_LevelTest extends Elite_Vaf_TestCase
{
    
    function testConstructorSetsType()
    {
        $entity = new VF_Level('make');   
        $this->assertSame('make', $entity->getType() );
    }
    
    function testConstructorSetsId()
    {
        $id = $this->insertMake();
        $entity = $this->findMakeById( $id );
        $this->assertSame( $id, $entity->getId() );
    }
    
    function testInitGetsTitle()
    {
        $id = $this->insertMake( self::ENTITY_TITLE );
        $entity = $this->findMakeById( $id );
        $this->assertSame( self::ENTITY_TITLE, $entity->getTitle() );
    }
    
    /**
    * @expectedException  Exception
    */
    function testInitThrowsExceptionForUnfoundId()
    {
        $this->findMakeById( self::NON_EXISTANT_ID );
    }
    
    /**
    * @expectedException VF_Level_Exception_InvalidLevel
    */
    function testInitThrowsExceptionIfTypeInvalid()
    {
        $id = $this->insertMake();
        $entity = new VF_Level( self::INVALID_TYPE, $id );
    }
    
    function testInitDoesNothingIfNoId()
    {
        try
        {
            $entity = new VF_Level( self::INVALID_TYPE, 0 );
        }
        catch( Exception $e )
        {
            return $this->assertTrue( false, 'instantiating with invalid type will not throw exception as long as no id was passed' );
        }
        $this->assertTrue( true, 'instantiating with invalid type will not throw exception as long as no id was passed' );
    }
    
    function testGetTitle()
    {
        $id = $this->insertMake( self::ENTITY_TITLE );
        $entity = $this->findMakeById( $id );
        $this->assertSame( self::ENTITY_TITLE, $entity->getTitle() );
    }
    
    function testCreatesDefinitionWhenSavingLeafLevel()
    {
        $make = new VF_Level( 'make' );
        $make->setTitle('Honda');
        $make_id = $make->save();
        
        $model = new VF_Level( 'model' );
        $model->setTitle('Civic');
        $model_id = $model->save( $make_id );
        
        $year = new VF_Level( 'year' );
        $year->setTitle('2000');
        $year_id = $year->save($model_id);

        $vehicleFinder = new VF_Vehicle_Finder(new VF_Schema);
        $vehicle = $vehicleFinder->findByLeaf($year_id);
        $this->assertEquals( $year_id, $vehicle->getLevel('year')->getId() );
    }
    
    function testCreatesDefinitionWhenSavingLeafLevel2()
    {
        return $this->markTestIncomplete();
      //  $schemaGenerator = new VF_Schema_Generator();
      //  $schemaGenerator->execute( 'make,model,trim,chassis', false);
    }
    
    function testDeleteFits()
    {
        $vehicle = $this->createMMY();
        $this->insertMappingMMY( $vehicle, 1 );
        $level = new VF_Level( 'year', $vehicle->getLevel('year')->getId() );
        $level->deleteFits();
    }
    
    function testPrefixingZero()
    {
        $make = $this->newMake('039');
        $id = $make->save();
        
        $entity = $this->findMakeById( $id );
        $this->assertSame( '039', $entity->getTitle() );
    }
    
    function testPrefixingZero2()
    {
        $make = $this->newMake('039');
        $make->save();
        $make = $this->newMake('039');
        $id1 = $make->save();
        
        $make = $this->newMake('39');
        $id2 = $make->save();
        
        $this->assertNotSame( $id1, $id2 );
    }
    
    function testShouldTrimWhitespace()
    {
        $make = $this->newMake(' 039 ');
        $id = $make->save();
        
        $make = $this->levelFinder()->findEntityByTitle('make','039');
        $this->assertEquals( $id, $make->getId(), 'should trim whitespace');
    }
    
    function levelFinder()
    {
        return new VF_Level_Finder();
    }
    
         
}