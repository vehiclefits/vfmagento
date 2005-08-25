<?php
class Elite_Vaf_Model_LevelTests_LevelsTest extends Elite_Vaf_TestCase
{
    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testGetType()
    {
        $entity = new Elite_Vaf_Model_Level('make');
        $this->assertSame( self::ENTITY_TYPE_MAKE, $entity->getType() );
    }

    function testgetNextLevelMake()
    {
        $entity = new Elite_Vaf_Model_Level('make');
        $this->assertEquals( self::ENTITY_TYPE_MODEL, $entity->getNextLevel(), 'getNextLevel should return "model" for a entity of type "make"' );
    }
    
    function testgetNextLevelModel()
    {
        $entity = new Elite_Vaf_Model_Level('model');
        $this->assertEquals( self::ENTITY_TYPE_YEAR, $entity->getNextLevel(), 'getNextLevel should return "year" for a entity of type "model"' );
    }
    
    function testgetNextLevelYear()
    {
        $entity = new Elite_Vaf_Model_Level('year');
        $this->assertEquals( '', $entity->getNextLevel(), 'getNextLevel should return emtpy string if called on a leaf level' );
    }
    
    function testgetPrevLevelMake()
    {
        $entity = new Elite_Vaf_Model_Level('make');
        $this->assertEquals( '', $entity->getPrevLevel(), 'getPrevLevel should return emtpy string if called on a root level' );
    }
    
    function testgetPrevLevelModel()
    {
        $entity = new Elite_Vaf_Model_Level('model');
        $this->assertEquals( self::ENTITY_TYPE_MAKE, $entity->getPrevLevel(), 'getPrevLevel should return "make" for a entity of type "model"' );
    }
    
    function testgetPrevLevelYear()
    {
        $entity = new Elite_Vaf_Model_Level('year');
        $this->assertEquals( self::ENTITY_TYPE_MODEL, $entity->getPrevLevel(), 'getPrevLevel should return "model" for a entity of type "year"' );
    }
    
          
}
