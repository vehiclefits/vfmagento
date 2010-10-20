<?php
class Elite_Vaf_Model_SchemaTests_PerformanceTest extends Elite_Vaf_TestCase
{

    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testUsesOneQuery()
    {
        $this->getReadAdapter()->getProfiler()->clear();
        $this->getReadAdapter()->getProfiler()->setEnabled(true);
        
        $schema = new Elite_Vaf_Model_Schema();
        $this->assertEquals( array( 'make','model','year'), $schema->getLevels(), 'should get levels MMY' );
        
        $queries = $this->getReadAdapter()->getProfiler()->getQueryProfiles();
        $this->assertEquals(1,count($queries));
    }
  
    function testUsesOneQueryOnMultipleCalls()
    {
        $this->getReadAdapter()->getProfiler()->clear();
        $this->getReadAdapter()->getProfiler()->setEnabled(true);
        
        $schema = new Elite_Vaf_Model_Schema();
        $schema->getLevels();
        $schema->getLevels();
        
        $queries = $this->getReadAdapter()->getProfiler()->getQueryProfiles();
        $this->assertEquals(1,count($queries));
    }
  
    function testOneQueryAcrossInstances()
    {
        $this->getReadAdapter()->getProfiler()->clear();
        $this->getReadAdapter()->getProfiler()->setEnabled(true);
        
        $schema = new Elite_Vaf_Model_Schema();
        $schema->getLevels();
        
        $schema = new Elite_Vaf_Model_Schema();
        $schema->getLevels();
        
        $queries = $this->getReadAdapter()->getProfiler()->getQueryProfiles();
        $this->assertEquals(1,count($queries));
    }
  

}
