<?php
class Elite_Vaf_Block_SearchTests_Search_ListEntitiesMMYTest extends Elite_Vaf_Block_SearchTests_TestCase
{
    /**
    * @expectedException VF_Level_Exception_InvalidLevel
    */
    function testListNoLevel()
    {
        $block = $this->getBlock();
        $actual = $block->listEntities('');
    }
        
    /**
    * @expectedException VF_Level_Exception_InvalidLevel
    */
    function testListInvalidLevel()
    {
        $block = $this->getBlock();
        $actual = $block->listEntities('foo');
    }
    
    // makes
    
    function testShouldListMakes_WhenNoVehicleIsSelected()
    {
        $vehicle = $this->createMMYWithFitment();
        $actual = $this->getBlock()->listEntities('make');
        $this->assertEquals( 1, count($actual) );
        $this->assertEquals( $vehicle->getLevel('make')->getId(), $actual[0]->getId() );
    }
       
    // models
    
    function testShouldBeNoModelsPreselected_WhenNoVehicleIsSelected()
    {
        $vehicle = $this->createMMYWithFitment();
        $actual = $this->getBlock()->listEntities('model');
        $this->assertEquals( array(), $actual, 'should be no models pre-selected when vehicle not selected' );
    }
    
    function testShouldListModels_WhenVehicleIsSelected()
    {
        $vehicle = $this->createMMYWithFitment();
        $_GET = $vehicle->toValueArray();
        $actual = $this->getBlock()->listEntities( 'model' );
        $this->assertEquals( 1, count($actual) );
        $this->assertEquals( $vehicle->getLevel('model')->getId(), $actual[0]->getId() );
    }
    
    function testShouldListModels_WhenPartialVehicleIsSelected()
    {
        $vehicle = $this->createMMYWithFitment();
        $_GET['make'] = $vehicle->getLevel('make')->getId();
        $_GET['model'] = $vehicle->getLevel('model')->getId();
        $actual = $this->getBlock()->listEntities( 'model' );
        $this->assertEquals( 1, count($actual) );
        $this->assertEquals( $vehicle->getLevel('model')->getId(), $actual[0]->getId() );
    }
    
    function getRequest( $params = array() )
    {
        $request = new Zend_Controller_Request_HttpTestCase();
        foreach( $params as $key => $val )
        {
            $request->setParam( $key, $val );
        }
        return $request;
    } 
    
}
