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
    
	function testShouldRetainOldModel()
    {
        $vehicle = $this->createMMY('Ford','F-150','2000');
        $this->split($vehicle, 'model', array('F-150', 'F-250'));
        
        $this->assertTrue( $this->vehicleExists(array('make'=>'Ford','model'=>'F-150','year'=>2000)), 'should retain old vehicle if it is in the resultant split' );
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
        $this->createVehicle(array('make'=>'Ford/Ford2'));
        
        $vehicle = $this->vehicleFinder()->findOneByLevels(array('make'=>'Ford/Ford2'), VF_Vehicle_Finder::INCLUDE_PARTIALS);
        
        $this->split($vehicle, 'make', array('Ford','Ford 2'));
        
        $this->assertFalse( $this->vehicleExists(array('make'=>'Ford') ) );
        $this->assertFalse( $this->vehicleExists(array('make'=>'Ford 2') ) );
        $this->assertTrue( $this->vehicleExists(array('make'=>'Ford/Ford2'),true ), 'should ignore partial vehicles' );
    }
    
    function testShouldSplitYears_PartiallyCreated()
    {
        $this->createVehicle(array('make'=>'Ford/Ford2','model'=>'foo','year'=>'2000'));

        $vehicle = $this->vehicleFinder()->findOneByLevels(array('make'=>'Ford/Ford2'), VF_Vehicle_Finder::EXACT_ONLY);
        $this->split($vehicle, 'make', array('Ford','Ford 2'));
        
        $this->assertTrue( $this->vehicleExists(array('make'=>'Ford') ) );
        $this->assertTrue( $this->vehicleExists(array('make'=>'Ford 2') ) );
        $this->assertFalse( $this->vehicleExists(array('make'=>'Ford/Ford2'),true ), 'should ignore partial vehicles' );
    }
    
    function testShouldSplitYears_Fitments()
    {
        $vehicle = $this->createMMY('Ford/Ford2','F-150','2001');
        $this->insertMappingMMY($vehicle, 1);
        
        $vehicle = $this->vehicleFinder()->findOneByLevelIds(array('make'=>$vehicle->getValue('make')), VF_Vehicle_Finder::EXACT_ONLY);
        $this->split($vehicle, 'make', array('Ford','Ford 2'));
        
        $product = $this->newProduct(1);
        $product->setCurrentlySelectedFit($this->vehicleFinder()->findOneByLevels(array('make'=>'Ford 2', 'model'=>'F-150', 'year'=>'2001')));
        $this->assertTrue( $product->fitsSelection() );
        
        $product = $this->newProduct(1);
        $product->setCurrentlySelectedFit($this->vehicleFinder()->findOneByLevels(array('make'=>'Ford', 'model'=>'F-150', 'year'=>'2001')));
        $this->assertTrue( $product->fitsSelection() );
    }
    
    function testShouldSplitAtGrain_Model()
    {
        $vehicle = $this->createMMY('Ford','F-150','2000');
        $this->split($vehicle, 'year', array('2000','2001'));
        $this->assertTrue($this->vehicleExists(array('make'=>'Ford', 'model'=>'F-150', 'year'=>'2000')));
        $this->assertTrue($this->vehicleExists(array('make'=>'Ford', 'model'=>'F-150', 'year'=>'2001')));

    }
    
    function testShouldSplitAtGrain_Model2()
    {
        $vehicle = $this->createMMY('Ford','F-150','200-2001');
        $this->split($vehicle, 'year', array('2000','2001'));
        $this->assertTrue($this->vehicleExists(array('make'=>'Ford', 'model'=>'F-150', 'year'=>'2000')));
        $this->assertTrue($this->vehicleExists(array('make'=>'Ford', 'model'=>'F-150', 'year'=>'2001')));

    }

}