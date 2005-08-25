<?php
class VF_Schema_GeneratorTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
    }
    
    function tearDown()
    {
        $schemaGenerator = new VF_Schema_Generator();
        $schemaGenerator->dropExistingTables();
    }
    
    /**
    * @expectedException VF_Level_Exception
    */
    function testShouldThrowExceptionForLessThanTwoLevels()
    {
        $this->schemaGenerator()->dropExistingTables();
        $this->schemaGenerator()->execute(array('make'));
    }
        
    function testMMY()
    {
        $this->schemaGenerator()->dropExistingTables();
        $this->schemaGenerator()->execute(array('make','model','year'));
        $this->assertEquals( array('make','model','year'), $this->schema()->getLevels(), 'should switch levels to MMY' );
    }
    
    function testYMM()
    {
        $this->schemaGenerator()->dropExistingTables();
        $this->schemaGenerator()->execute(array('year','make','model'));
        $this->assertEquals( array('year','make','model'), $this->schema()->getLevels(), 'should switch levels to YMM' );
    }
    
    function testYMM_MakeIsGlobal()
    {
        $this->schemaGenerator()->dropExistingTables();
        $this->schemaGenerator()->execute(array('year','make'=>array('global'=>true),'model'));
        $this->assertTrue( $this->schema()->isGlobal('make'), 'make should be global' );
    }
       
    function testYMM_MakeShouldNotHaveParent_WhenGlobal()
    {
        $this->schemaGenerator()->dropExistingTables();
        $this->schemaGenerator()->execute(array('year','make'=>array('global'=>true),'model'));
        $this->assertFalse( $this->schema()->hasParent('make'), 'make should not have parent when global' );
    }
        
    function testYMM_MakeIsNotGlobal()
    {
        $this->schemaGenerator()->dropExistingTables();
        $this->schemaGenerator()->execute(array('year','make','model'));
        $this->assertFalse( $this->schema()->isGlobal('make'), 'make should not be global' );
    }
            
    function testYMM_MakeShouldHaveParent_WhenNotGlobal()
    {
        $this->schemaGenerator()->dropExistingTables();
        $this->schemaGenerator()->execute(array('year','make','model'));
        $this->assertTrue( $this->schema()->hasParent('make'), 'make should have parent when not global' );
    }
                
    function testYMM_YearShouldNotHaveParent_WhenGlobal()
    {
        $this->schemaGenerator()->dropExistingTables();
        $this->schemaGenerator()->execute(array('year'=>array('global'=>true),'make','model'));
        $this->assertFalse( $this->schema()->hasParent('year'), 'year should not have parent' );
    }
    
    function testYMM_YearIsInvariablyGlobal()
    {
        $this->schemaGenerator()->dropExistingTables();
        $this->schemaGenerator()->execute(array('year','make','model'));
        $this->assertTrue( $this->schema()->isGlobal('year'), 'year should be invariably global' );
    }
    
    function testMMY_MakeIsInvariablyGlobal()
    {
        $this->schemaGenerator()->dropExistingTables();
        $this->schemaGenerator()->execute(array('make','model','year'));
        $this->assertTrue( $this->schema()->isGlobal('make'), 'make should be invariably global' );
    }
    
    function schema()
    {
        return new VF_Schema();
    }
}