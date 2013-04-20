<?php
class Elite_Vaf_Block_SearchTests_Search_ListEntitiesMMYAlnumTest extends Elite_Vaf_Block_SearchTests_TestCase
{

    // makes
    
    function testShouldListMakes_WhenNoVehicleIsSelected()
    {
        $vehicle = $this->createMMYWithFitment();
        $actual = $this->getBlock()->listEntities('make');
        $this->assertEquals( 1, count($actual) );
        $this->assertEquals( $vehicle->getLevel('make')->getTitle(), $actual[0]->getTitle() );
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
        $_GET = $vehicle->toTitleArray();
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
