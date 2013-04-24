<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
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

    function testWhenTwoVehiclesHaveSameYear()
    {
        $vehicle1 = $this->createVehicle(array('make'=>'Honda','model'=>'Civic','year'=>'2000'));
        $vehicle2 = $this->createVehicle(array('make'=>'Acura','model'=>'Integra','year'=>'2000'));

        $helper = $this->getHelper( array(), $vehicle1->toValueArray() );

        $this->assertEquals( $vehicle1->getLevel('make')->getId(), $helper->flexibleSearch()->getFlexibleDefinition()->getValue('make') );
    }
    
}