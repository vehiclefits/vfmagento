<?php
class Elite_Vaf_Model_Level_FinderTests_MergeTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    // @todo what about a way to merge a make with a model, or year (by traversing the level closest to the root level, and "blowing out" all applicable vehicles).
    function testShouldMergeYear()
    {
        $vehicle1 = $this->createMMY('Honda','Civic','2000');
        $vehicle2 = $this->createMMY('Honda','Civic','2001');
        
        $year1 = $vehicle1->getLevel('year');
        $year2 = $vehicle2->getLevel('year');
        
        $levelsToBeMerged = array('year'=>$year1,'year'=>$year2);
        $levelToMergeInto = array('year'=>$year2);
        $this->levelFinder()->merge( $levelsToBeMerged, $levelToMergeInto );
        
        return $this->markTestIncomplete();
        $this->assertTrue( $this->vehicleExists(array('make'=>'Honda','model'=>'Civic','year'=>2000)) );
        $this->assertFalse( $this->vehicleExists(array('make'=>'Honda','model'=>'Civic','year'=>2001)) );
    }
    
    function testShouldMergeProductApplications()
    {
        return $this->markTestIncomplete();
    }
    
    function testShouldClearVehicleFinderIdentityMap()
    {
        return $this->markTestIncomplete();
    }
    
    function testShouldClearLevelFinderIdentityMap()
    {
        return $this->markTestIncomplete();
    }
    
}