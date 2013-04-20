<?php
class VF_SchemaTests_MultipleTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,option,year');
    }
    
    function testCreateNewSchemaId()
    {
        $schema = VF_Schema::create('foo,bar');
        $this->assertTrue( $schema->id() > 0 );
    }
    
    function testGetsDefaultSchemaAfterCreatingNew()
    {
        $schema1 = VF_Schema::create('foo,bar');
        $schema2 = new VF_Schema;
        $this->assertEquals(array('make','model','option','year'),$schema2->getLevels(), 'should get default schemas levels after creating new');
    }
    
    function testGetNewSchemasLevels()
    {
        $schema1 = VF_Schema::create('foo,bar');
        $schema2 = new VF_Schema;
        $this->assertEquals(array('foo','bar'),$schema1->getLevels(), 'should get new schemas levels');
    }
}