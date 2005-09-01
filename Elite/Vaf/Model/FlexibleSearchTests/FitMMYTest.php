<?php
class Elite_Vaf_Model_FlexibleSearchTests_FitMMYTest extends Elite_Vaf_Helper_DataTestCase
{
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testGetFitId()
    {
        $vehicle = $this->createMMY();
        $helper = $this->getHelper( array(), array(
                'make'=>$vehicle->getLevel('make')->getId(),
                'model'=>$vehicle->getLevel('model')->getId(),
                'year'=>$vehicle->getLevel('year')->getId()
        ) );
        $this->assertEquals( $vehicle->getLevel('year')->getId(), $helper->getFit()->getLeafValue() );
    }
    
    function testGetFitId2()
    {
        $vehicle = $this->createMMY();
        $helper = $this->getHelper( array(), array(
                'make'=>$vehicle->getLevel('make')->getId(),
                'model'=>$vehicle->getLevel('model')->getId(),
                'year'=>$vehicle->getLevel('year')->getId()
        ) );
        $this->assertEquals( $vehicle->getLevel('year')->getId(), $helper->getFit()->getLeafValue() );
    }
    
    function testGetFitIdMultiTree()
    {
        $vehicle = $this->createMMY();
        $helper = $this->getHelper( array(), array('fit'=>$vehicle->getLevel('year')->getId()) );
        $this->assertEquals( $vehicle->getLevel('year')->getId(), $helper->getFit()->getLeafValue() );
    }
    
    function testClearsWhenPassed0ForEachValue()
    {
        $_SESSION = array('make'=>1, 'model'=>1, 'year'=>1);
        $helper = $this->getHelper( array(), array('make'=>0, 'model'=>0, 'year'=>0) );
        $this->assertFalse( $helper->getFit(), 'request values should take precedence over session value' );
        $this->assertFalse( isset( $_SESSION['make'] ), 'passing 0 in request should reset session value' );
    }
    
    function testShouldStoreInSession()
    {
        $_SESSION = array('make'=>null, 'model'=>null, 'year'=>null);
        $vehicle = $this->createMMY();
        $helper = $this->getHelper( array(), $vehicle->toValueArray() );
        $helper->storeFitInSession();
        unset($_SESSION['garage']);
        $this->assertEquals( $vehicle->toValueArray(), $_SESSION, 'should store vehicle in session' );
    }
    
    function testShouldNotStoreInSession()
    {
        $_SESSION = array('make'=>null, 'model'=>null, 'year'=>null);
        $vehicle = $this->createMMY();
        $helper = $this->getHelper( array('search'=>array('storeVehicleInSession' => '')), $vehicle->toValueArray() );
        $helper->storeFitInSession();
        unset($_SESSION['garage']);
        $this->assertNotEquals( $vehicle->toValueArray(), $_SESSION, 'should not store in session when disabled' );
    }

    function testShouldNotStoreInSession2()
    {
        $_SESSION = array('make'=>null, 'model'=>null, 'year'=>null);
        $vehicle = $this->createMMY();
        $helper = $this->getHelper( array('search'=>array('storeVehicleInSession' => '')), $vehicle->toValueArray() );

        $flexibleSearch = new Elite_Vaf_Model_FlexibleSearch(new Elite_Vaf_Model_Schema, $this->getRequest($vehicle->toValueArray()));
        $flexibleSearch->storeFitInSession();
        
        unset($_SESSION['garage']);
        $this->assertNotEquals( $vehicle->toValueArray(), $_SESSION, 'should get global configuration' );
    }

    function testGetsIdFromSession()
    {
        $vehicle = $this->createMMY();
        $_SESSION = $vehicle->toValueArray();
        $helper = $this->getHelper( array(), array() );
        $this->assertEquals( $vehicle->getLevel('year')->getId(), $helper->getFit()->getLeafValue(), 'gets fit id from session if there is no request' );
        $this->assertEquals( $vehicle->getLevel('year')->getId(), $helper->storeFitInSession(), 'gets fit id from session if there is no request' );
    }
    
    function testgetValueForSelectedLevel()
    {
        $vehicle = $this->createMMY();
        $helper = $this->getHelper( array(), $vehicle->toValueArray() );
        $this->assertEquals( $vehicle->getLevel('make')->getId(), $helper->getValueForSelectedLevel('make') );
    }
}