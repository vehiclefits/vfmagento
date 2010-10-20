<?php
class Elite_Vaf_Model_LevelTests_FinderTests_FindPerformanceTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testUsesOneQuery()
    {
        $level = new Elite_Vaf_Model_Level('make');
        $level->setTitle('make');
        $id = $level->save();
        
        $this->getReadAdapter()->getProfiler()->clear();
        $this->getReadAdapter()->getProfiler()->setEnabled(true);
        
        $level = new Elite_Vaf_Model_Level('make',$id);
        
        $queries = $this->getReadAdapter()->getProfiler()->getQueryProfiles();
        $this->assertEquals(1,count($queries));
    }
  
    function testUsesOneQueryOnMultipleCalls()
    {
        $level = new Elite_Vaf_Model_Level('make');
        $level->setTitle('make');
        $id = $level->save();
        
        $this->getReadAdapter()->getProfiler()->clear();
        $this->getReadAdapter()->getProfiler()->setEnabled(true);
        
        $level = new Elite_Vaf_Model_Level('make',$id);
        $level = new Elite_Vaf_Model_Level('make',$id);
        
        $queries = $this->getReadAdapter()->getProfiler()->getQueryProfiles();
        $this->assertEquals(1,count($queries));
    }

}