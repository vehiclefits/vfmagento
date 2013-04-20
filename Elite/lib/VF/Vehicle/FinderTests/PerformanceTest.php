<?php
class VF_Vehicle_FinderTests_PerformanceTest extends Elite_Vaf_TestCase
{
    function testFindById()
    {
        $vehicle = $this->createMMY();
        $finder = new VF_Vehicle_Finder(new VF_Schema());
        
        $this->getReadAdapter()->getProfiler()->clear();
        $this->getReadAdapter()->getProfiler()->setEnabled(true);
        
        $finder->findById($vehicle->getId());
        $finder->findById($vehicle->getId());
        
        $queries = $this->getReadAdapter()->getProfiler()->getQueryProfiles();
        $this->assertEquals(1,count($queries));
    }
    
    function testFindByLevel()
    {
        $vehicle = $this->createMMY();
        $yearId = $vehicle->getValue('year');
        
        $finder = new VF_Vehicle_Finder(new VF_Schema());
        
        $this->getReadAdapter()->getProfiler()->clear();
        $this->getReadAdapter()->getProfiler()->setEnabled(true);
        
        $finder->findByLevel('year',$yearId);
        $finder->findByLevel('year',$yearId);
        
        $queries = $this->getReadAdapter()->getProfiler()->getQueryProfiles();
        $this->assertEquals(1,count($queries));
    }
    
    function testFindByLeaf()
    {
        $vehicle = $this->createMMY();
        $yearId = $vehicle->getValue('year');
        
        $finder = new VF_Vehicle_Finder(new VF_Schema());
        
        $this->getReadAdapter()->getProfiler()->clear();
        $this->getReadAdapter()->getProfiler()->setEnabled(true);
        
        $finder->findByLeaf($yearId);
        $finder->findByLeaf($yearId);
        
        $queries = $this->getReadAdapter()->getProfiler()->getQueryProfiles();
        $this->assertEquals(1,count($queries));
    }
}