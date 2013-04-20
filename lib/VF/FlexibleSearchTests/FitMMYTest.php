<?php
class VF_FlexibleSearchTests_FitMMYTest extends Elite_Vaf_Helper_DataTestCase
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
        $this->assertEquals( $vehicle->getLevel('year')->getId(), $helper->vehicleSelection()->getLeafValue() );
    }
    
    function testGetFitId2()
    {
        $vehicle = $this->createMMY();
        $helper = $this->getHelper( array(), array(
                'make'=>$vehicle->getLevel('make')->getId(),
                'model'=>$vehicle->getLevel('model')->getId(),
                'year'=>$vehicle->getLevel('year')->getId()
        ) );
        $this->assertEquals( $vehicle->getLevel('year')->getId(), $helper->vehicleSelection()->getLeafValue() );
    }
    
    function testGetFitIdMultiTree()
    {
        $vehicle = $this->createMMY();
        $helper = $this->getHelper( array(), array('fit'=>$vehicle->getLevel('year')->getId()) );
        $this->assertEquals( $vehicle->getLevel('year')->getId(), $helper->vehicleSelection()->getLeafValue() );
    }
    
    function testClearsWhenPassed0ForEachValue()
    {
        $_SESSION = array('make'=>1, 'model'=>1, 'year'=>1);
        $helper = $this->getHelper( array(), array('make'=>0, 'model'=>0, 'year'=>0) );
        $this->assertTrue( $helper->vehicleSelection()->isEmpty(), 'request values should take precedence over session value' );
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
    
    function testShouldNotStoreInSessionWhenFalse()
    {
        $_SESSION = array('make'=>null, 'model'=>null, 'year'=>null);
        $vehicle = $this->createMMY();
        $helper = $this->getHelper( array('search'=>array('storeVehicleInSession' => 'false')), $vehicle->toValueArray() );
        $helper->storeFitInSession();
        unset($_SESSION['garage']);
        $this->assertNotEquals( $vehicle->toValueArray(), $_SESSION, 'should not store in session when disabled' );
    }

    function testShouldNotStoreInSession2()
    {
        $_SESSION = array('make'=>null, 'model'=>null, 'year'=>null);
        $vehicle = $this->createMMY();
        $helper = $this->getHelper( array('search'=>array('storeVehicleInSession' => '')), $vehicle->toValueArray() );

        $flexibleSearch = new VF_FlexibleSearch(new VF_Schema, $this->getRequest($vehicle->toValueArray()));
        $flexibleSearch->storeFitInSession();
        
        unset($_SESSION['garage']);
        $this->assertNotEquals( $vehicle->toValueArray(), $_SESSION, 'should get global configuration' );
    }
    
    function testShouldNotHaveRequest()
    {
        $helper = $this->getHelper( array(), array() );
        $this->assertFalse($helper->flexibleSearch()->hasRequest());
    }
    
    function testShouldNotHaveGETRequest()
    {
        $helper = $this->getHelper( array(), array() );
        $this->assertFalse($helper->flexibleSearch()->hasGETRequest());
    }
    
    function testShouldNotHaveSESSIONRequest()
    {
        $helper = $this->getHelper( array(), array() );
        $this->assertFalse($helper->flexibleSearch()->hasSESSIONRequest());
    }
    
    function testShouldHaveSESSIONRequest()
    {
        $vehicle = $this->createMMY();
        $_SESSION = $vehicle->toValueArray();
        $helper = $this->getHelper( array(), array() );
        $this->assertTrue($helper->flexibleSearch()->hasSESSIONRequest());
    }

    function testGetsMakeIdFromSession()
    {
        $vehicle = $this->createMMY();
        $_SESSION = $vehicle->toValueArray();
        $helper = $this->getHelper( array(), array() );
        $this->assertEquals( $vehicle->getLevel('make')->getId(), $helper->flexibleSearch()->getValueForSelectedLevel('make'));
    }

    function testGetsYearIdFromSession()
    {
        $vehicle = $this->createMMY();
        $_SESSION = $vehicle->toValueArray();
        $helper = $this->getHelper( array(), array() );
        $this->assertEquals( $vehicle->getLevel('year')->getId(), $helper->flexibleSearch()->getValueForSelectedLevel('year'));
    }

    function testGetsIdFromSession()
    {
        $vehicle = $this->createMMY();
        $_SESSION = $vehicle->toValueArray();
        $helper = $this->getHelper( array(), array() );
        $this->assertEquals( $vehicle->getLevel('year')->getId(), $helper->vehicleSelection()->getLeafValue(), 'gets fit id from session if there is no request' );
        $this->assertEquals( $vehicle->getLevel('year')->getId(), $helper->storeFitInSession(), 'storeFitInSession() should return leafID' );
    }
    
    function testShouldAutomaticallyClearInvalidSession()
    {
        $_SESSION = array('make'=>99, 'model'=>99, 'year'=>99);
        $helper = $this->getHelper();
        $flexibleSearch = new VF_FlexibleSearch(new VF_Schema, $this->getRequest());
        $this->assertFalse($flexibleSearch->getFlexibleDefinition(), 'when fitment is deleted should automatically clear invalid session');
    }
    
    function testgetValueForSelectedLevel()
    {
        $vehicle = $this->createMMY();
        $helper = $this->getHelper( array(), $vehicle->toValueArray() );
        $this->assertEquals( $vehicle->getLevel('make')->getId(), $helper->getValueForSelectedLevel('make') );
    }
}