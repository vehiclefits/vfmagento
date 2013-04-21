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
class VF_VehicleTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testSaveParenetheses()
    {
        $this->createMMY('FMC','HPSC-156 (PEAS)','1994');
        $this->assertTrue($this->vehicleExists(array('make'=>'FMC','model'=>'HPSC-156 (PEAS)', 'year'=>1994)), 'should be able to save vehicle with parentheses in its name');
    }
    
    function testSavePrefixingZero()
    {
        $this->createMMY('FHIL','039','1999');
        $this->assertTrue($this->vehicleExists(array('make'=>'FHIL','model'=>'039', 'year'=>1999)));
        $this->assertFalse($this->vehicleExists(array('make'=>'FHIL','model'=>'39', 'year'=>1999)));        
    }
        
    function testSavePrefixingZero2()
    {
        $this->createMMY('FHIL','039','1999');
        $this->createMMY('FHIL','039','1999');
        $this->createMMY('FHIL','39','1999');
        $this->assertTrue($this->vehicleExists(array('make'=>'FHIL','model'=>'039', 'year'=>1999)));
        $this->assertTrue($this->vehicleExists(array('make'=>'FHIL','model'=>'39', 'year'=>1999)));        
    }
        
    function testShouldTrimWhitespaces()
    {
        $this->createMMY('FHIL',' 039 ','1999');
        $this->assertTrue($this->vehicleExists(array('make'=>'FHIL','model'=>'039', 'year'=>1999)));
    }
    
    function testShouldTrimWhitespaces2()
    {
        $this->createVehicle(array('make'=>'Honda ', 'model'=>'Civic', 'year'=>'2000'));
        $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>'2000'));
        
        $vehicles = $this->vehicleFinder()->findByLevels(array('year'=>'2000'));
        $this->assertEquals(1, count($vehicles));
    }

    function testToString()
    {
        $vehicle = $this->createMMY('Honda','Civic','2000');
        $this->assertEquals( 'Honda Civic 2000', $vehicle->__toString(), 'should convert vehicle to string');
    }

    function testToStringTemplate()
    {
        $vehicle = $this->createMMY('Honda','Civic','2000');
	$vehicle->setConfig(new Zend_Config(array('search'=>array('vehicleTemplate'=>'%make% %model%'))));
        $this->assertEquals( 'Honda Civic', $vehicle->__toString(), 'should convert vehicle to string');
    }

    function testLevelIdsTruncateAfter()
    {
        $vehicle = $this->createMMY('Honda','Civic','2000');
        $truncateAfter = $vehicle->levelIdsTruncateAfter('model');
        $this->assertEquals($vehicle->getValue('make'), $truncateAfter['make'] );
        $this->assertEquals($vehicle->getValue('model'), $truncateAfter['model'] );
        $this->assertFalse( isset($truncateAfter['year'] ) );
    }
}