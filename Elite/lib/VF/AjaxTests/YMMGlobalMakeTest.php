<?php
class Vf_AjaxTests_YMMGlobalMakeTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $schemaGenerator = new VF_Schema_Generator();
        $schemaGenerator->dropExistingTables();
        $schemaGenerator->execute( array('year', 'make'=>array('global'=>true), 'model') );
        
        $this->startTransaction();
    }    
    
    function testListYears()
    {
        return $this->markTestIncomplete();
    }    
    
    function testShouldSortMake()
    {
        return $this->markTestIncomplete();
    }
    
    function testShouldListModels()
    {
        return $this->markTestIncomplete();
    }
    
    function testShouldSortModels()
    {
        return $this->markTestIncomplete();
    }
}