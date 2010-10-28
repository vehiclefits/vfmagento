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
        
        $levelsToBeMerged = array(
            'year'=>$vehicle1,
            'year'=>$vehicle2
        );
        $levelToMergeInto = array(
            'year'=>$vehicle2
        );
        $this->levelFinder()->merge( $levelsToBeMerged, $levelToMergeInto );
        
        $this->assertTrue( $this->vehicleExists(array('make'=>'Honda','model'=>'Civic','year'=>2000)) );
        $this->assertFalse( $this->vehicleExists(array('make'=>'Honda','model'=>'Civic','year'=>2001)) );
    }
    
    function testShouldMergeModel()
    {
        $vehicle1 = $this->createMMY('Honda','Civic','2000');
        $vehicle2 = $this->createMMY('Honda','Accord','2001');
        
        $model1 = $vehicle1->getLevel('model');
        $model2 = $vehicle2->getLevel('model');
        
        $levelsToBeMerged = array(
            'model'=>$vehicle1,
            'model'=>$vehicle2
        );
        $levelToMergeInto = array(
            'model'=>$vehicle2
        );
        $this->levelFinder()->merge( $levelsToBeMerged, $levelToMergeInto );
        
        $this->assertTrue( $this->vehicleExists(array('make'=>'Honda','model'=>'Civic','year'=>2000)) );
        $this->assertFalse( $this->vehicleExists(array('make'=>'Honda','model'=>'Accord','year'=>2001)) );
    }
    
    
    function testShouldMergeYears_WhenMergeModel()
    {
        return $this->markTestIncomplete();
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