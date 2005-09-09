<?php
class VF_FlexibleSearchTests_FitPartialSelectionTest extends Elite_Vaf_Helper_DataTestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testShouldIgnoreLoadingModel()
    {
        $vehicle = $this->createMMY();
        $requestParams = array(
        	'make'=>$vehicle->getLevel('make')->getId(),
        	'model'=>'loading',
        	'year'=>'loading'
        );
        $helper = $this->getHelper( array(), $requestParams );
        
        $this->assertFalse($helper->flexibleSearch()->getValueForSelectedLevel('model'));
    }
    
    
    function testShouldBeNumericWhenLoading()
    {
        $vehicle = $this->createMMY();
        $requestParams = array(
        	'make'=>$vehicle->getLevel('make')->getId(),
        	'model'=>'loading',
        	'year'=>'loading'
        );
        $helper = $this->getHelper( array(), $requestParams );
        
        $this->assertTrue($helper->flexibleSearch()->isNumericRequest());
    }
    
    function testShouldReadMakeWhenModelLoading()
    {
        $vehicle = $this->createMMY();
        $requestParams = array(
        	'make'=>$vehicle->getLevel('make')->getId(),
        	'model'=>'loading',
        	'year'=>'loading'
        );
        $helper = $this->getHelper( array(), $requestParams );
        
        $this->assertEquals($vehicle->getValue('make'),$helper->flexibleSearch()->getValueForSelectedLevel('make'));
    }
    
    
    function testShouldReturnDefinition()
    {
        $vehicle = $this->createMMY();
        $requestParams = array(
        	'make'=>$vehicle->getLevel('make')->getId(),
        	'model'=>'loading',
        	'year'=>'loading'
        );
        $helper = $this->getHelper( array(), $requestParams );
        
        $this->assertEquals( $vehicle->getLevel('make')->getId(), $helper->vehicleSelection()->getValue('make') );
        $this->assertEquals( 0, $helper->vehicleSelection()->getValue('model') );
        $this->assertEquals( 0, $helper->vehicleSelection()->getValue('year') );
    }
    
    function testShouldStoreInSession()
    {
        $_SESSION = array('make'=>null, 'model'=>null, 'year'=>null);
        $vehicle = $this->createMMY();
        $requestParams = array(
            'make'=>$vehicle->getLevel('make')->getId(),
            'model'=>'loading',
            'year'=>'loading'
        );
        $helper = $this->getHelper( array(), $requestParams );
        $helper->storeFitInSession();
        
        $this->assertEquals( $vehicle->getLevel('make')->getId(), $_SESSION['make'], 'should store make in session' );
        $this->assertFalse( $_SESSION['model'] );
        $this->assertFalse( $_SESSION['year'] );
    }
       
    function testShouldFindProducts()
    {
        $_SESSION = array('make'=>null, 'model'=>null, 'year'=>null);
        $vehicle = $this->createMMY();
        $this->insertMappingMMY($vehicle,1);
        $requestParams = array(
        	'make'=>$vehicle->getLevel('make')->getId(),
        	'model'=>'loading',
        	'year'=>'loading'
        );
        $helper = $this->getHelper( array(), $requestParams );
        $helper->storeFitInSession();
        
        $this->assertEquals( array(1), $helper->getProductIds() );
    }
        
    function testShouldOverwriteAFullSelection()
    {
        $vehicle = $this->createMMY();
        $_SESSION = $vehicle->toValueArray();
        $helper = $this->getHelper( array(), $vehicle->toValueArray() );
        $helper->storeFitInSession();
        
        $requestParams = array(
        	'make'=>$vehicle->getLevel('make')->getId(),
        	'model'=>'loading',
        	'year'=>'loading'
        );
        $helper = $this->getHelper( array(), $requestParams );
        $helper->storeFitInSession();
        
        $this->assertEquals( $vehicle->getLevel('make')->getId(), $_SESSION['make'] );
        $this->assertFalse( $_SESSION['model'] );
        $this->assertFalse( $_SESSION['year'] );
    }
    
}