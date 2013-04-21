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
