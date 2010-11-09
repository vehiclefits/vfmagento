<?php
class Elite_Vaf_Model_SplitTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    /**
    * @expectedException Elite_Vaf_Model_Split_Exception
    */
    function testNoGrainShouldThrowException()
    {
        $vehicle = $this->createMMY('Ford','F-150/F-250','2000');
        $this->split($vehicle, '', array('F-150', 'F-250'));
    }
    
    function testShouldSplitModel()
    {
        $vehicle = $this->createMMY('Ford','F-150/F-250','2000');
        $this->split($vehicle, 'model', array('F-150', 'F-250'));
        
        $this->assertTrue( $this->vehicleExists(array('make'=>'Ford','model'=>'F-150','year'=>2000)) );
        $this->assertTrue( $this->vehicleExists(array('make'=>'Ford','model'=>'F-250','year'=>2000)) );
        $this->assertFalse( $this->vehicleExists(array('make'=>'Ford','model'=>'F-150/F-250','year'=>2000)), 'should delete old vehicle' );
    }
        
    function testShouldSplitModel_MultipleYears()
    {
        $this->createMMY('Ford','F-150/F-250','2001');
        $vehicle = $this->createMMY('Ford','F-150/F-250','2000');
        
        $this->split($vehicle, 'model', array('F-150', 'F-250'));
        
        $this->assertTrue( $this->vehicleExists(array('make'=>'Ford','model'=>'F-150','year'=>2000)) );
        $this->assertTrue( $this->vehicleExists(array('make'=>'Ford','model'=>'F-150','year'=>2001)) );
        $this->assertTrue( $this->vehicleExists(array('make'=>'Ford','model'=>'F-250','year'=>2000)) );
        $this->assertTrue( $this->vehicleExists(array('make'=>'Ford','model'=>'F-250','year'=>2001)) );
        $this->assertFalse( $this->vehicleExists(array('make'=>'Ford','model'=>'F-150/F-250','year'=>2000)), 'should delete old vehicle' );
        $this->assertFalse( $this->vehicleExists(array('make'=>'Ford','model'=>'F-150/F-250','year'=>2001)), 'should delete old vehicle' );
    }
    
    function testShouldSplitMake()
    {
        $vehicle = $this->createMMY('Ford/Ford 2','F-150','2000');
        
        $this->split($vehicle, 'make', array('Ford','Ford 2'));
        
        $this->assertTrue( $this->vehicleExists(array('make'=>'Ford','model'=>'F-150','year'=>2000)) );
        $this->assertTrue( $this->vehicleExists(array('make'=>'Ford 2','model'=>'F-150','year'=>2000)) );
    }
    
    function testShouldSplitMake_Partial()
    {
        $level = $this->newMake('Ford/Ford2');
        $level->save();
        
        $vehicle = $this->vehicleFinder()->findOneByLevelIds(array('make'=>$level->getId()), Elite_Vaf_Model_Vehicle_Finder::EXACT_ONLY);
        
        $this->split($vehicle, 'make', array('Ford','Ford 2'));
        
        $this->assertFalse( $this->vehicleExists(array('make'=>'Ford') ) );
        $this->assertFalse( $this->vehicleExists(array('make'=>'Ford 2') ) );
        $this->assertTrue( $this->vehicleExists(array('make'=>'Ford/Ford2'),true ), 'should ignore partial vehicles' );
    }
    
    function testShouldSplitYears_PartiallyCreated()
    {
        $make = $this->newMake('Ford/Ford2');
        $make->save();
        
        $model = $this->newModel('Model');
        $model->save(array('make'=>$make->getId()));
        
        $year = $this->newYear('2000');
        $year->save(array('make'=>$make->getId(), 'model'=>$model->getId()));
        
        $vehicle = $this->vehicleFinder()->findOneByLevelIds(array('make'=>$make->getId()), Elite_Vaf_Model_Vehicle_Finder::EXACT_ONLY);
        $this->split($vehicle, 'make', array('Ford','Ford 2'));
        
        $this->assertTrue( $this->vehicleExists(array('make'=>'Ford') ) );
        $this->assertTrue( $this->vehicleExists(array('make'=>'Ford 2') ) );
        $this->assertFalse( $this->vehicleExists(array('make'=>'Ford/Ford2'),true ), 'should ignore partial vehicles' );
    }
    
    function testShouldSplitYears_Fitments()
    {
        $vehicle = $this->createMMY('Ford/Ford2','F-150','2001');
        $this->insertMappingMMY($vehicle, 1);
        
        $vehicle = $this->vehicleFinder()->findOneByLevelIds(array('make'=>$vehicle->getValue('make')), Elite_Vaf_Model_Vehicle_Finder::EXACT_ONLY);
        $this->split($vehicle, 'make', array('Ford','Ford 2'));
        
        $product = $this->newProduct(1);
        $product->setCurrentlySelectedFit($this->vehicleFinder()->findOneByLevels(array('make'=>'Ford 2', 'model'=>'F-150', 'year'=>'2001')));
        $this->assertTrue( $product->fitsSelection() );
        
        $product = $this->newProduct(1);
        $product->setCurrentlySelectedFit($this->vehicleFinder()->findOneByLevels(array('make'=>'Ford', 'model'=>'F-150', 'year'=>'2001')));
        $this->assertTrue( $product->fitsSelection() );
    }
    
    function split($vehicle, $grain, $newTitles)
    {
        $merge = new Elite_Vaf_Model_Split($vehicle, $grain, $newTitles);
        $merge->execute();
    }
}