<?php
class VF_SchemaTests_MMY_SchemaTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testLevels()
    {
        $schema = new VF_Schema();
        $this->assertEquals( array( 'make','model','year'), $schema->getLevels(), 'should get levels' );
    }
    
    function testGetRootLevel()
    {
        $schema = new VF_Schema();
        $this->assertEquals( self::ENTITY_TYPE_MAKE, $schema->getRootLevel(), 'root level should be "make"' );
    }
    
    function testGetLeafLevel()
    {
        $schema = new VF_Schema();
        $this->assertEquals( self::ENTITY_TYPE_YEAR, $schema->getLeafLevel(), 'root level should be "year"' );
    }
    
    function testPrevLevelMake()
    {
        $schema = new VF_Schema(); 
        $this->assertEquals( false, $schema->getPrevLevel('make') );
    }
    
    function testPrevLevelModel()
    {
        $schema = new VF_Schema(); 
        $this->assertEquals( 'make', $schema->getPrevLevel('model') );
    }
    
    function testNextLevelMake()
    {
        $schema = new VF_Schema(); 
        $this->assertEquals( 'model', $schema->getNextLevel('make') );
    }
    
    function testNextLevelModel()
    {
        $schema = new VF_Schema(); 
        $this->assertEquals( 'year', $schema->getNextLevel('model') );
    }
    
    function testNextLevelYear()
    {
        $schema = new VF_Schema(); 
        $this->assertFalse( $schema->getNextLevel('year') );
    }
    
    function testLevelIsBefore()
    {
        $schema = new VF_Schema();
        $this->assertTrue( $schema->levelIsBefore( 'make', 'model' ) );
    }
    
    function testLevelIsBefore2()
    {
        $schema = new VF_Schema();
        $this->assertFalse( $schema->levelIsBefore( 'model', 'make' ) );
    }
    
    function testGetLevelsExceptLeaf()
    {
        $schema = new VF_Schema();
        $this->assertSame( array('make','model'), $schema->getLevelsExceptLeaf() );
    }
    
    function testGetLevelsExcluding()
    {
        $schema = new VF_Schema();
        $this->assertSame( array('make','year'), $schema->getLevelsExcluding('model') );
    }
    
    function testGetLevelsExceptRoot()
    {
        $schema = new VF_Schema();
        $this->assertSame( array('model','year'), $schema->getLevelsExceptRoot() );
    }
}
