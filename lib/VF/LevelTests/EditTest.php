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
class VF_LevelTests_EditTest extends Elite_Vaf_TestCase
{
	function doSetUp()
	{
		$this->switchSchema('make,model,year');
	}
	
    function testShouldEditLevel()
    {
        $make = $this->createMMY('Honda','Civic','2000')->getLevel('make');
        $make->setTitle('honda')->save();
        $make = $this->findMakeById($make->getId());
        $this->assertEquals('honda',$make->getTitle(),'should be able to change the case of a level');
    }
    
    function testShouldEditNotCopyMake()
    {
        $make = $this->createMMY('a','Civic','2000')->getLevel('make');
        $make->setTitle('b')->save();
        $this->assertFalse($this->vehicleExists(array('make'=>'a')), 'should edit not copy the old make');
    }
    
    function testShouldEditNotCopyModel()
    {
        $vehicle = $this->createMMY('Honda','a','2000');
        $vehicle->getLevel('model')->setTitle('b')->save($vehicle->getValue('make'));
        $this->assertFalse($this->vehicleExists(array('model'=>'a')), 'should edit not copy the old model');
    }
    
    
	function testShouldEditNotCopyModel2()
	{
		$vehicle = $this->createMMY('Honda','a','2000');
        $vehicle->getLevel('model')->setTitle('b')->save($vehicle->toValueArray());
		$this->assertFalse($this->vehicleExists(array('model'=>'a')), 'should edit not copy the old model');
	}
	
	/**
	* @expectedException Exception
	*/
	function testShouldNotAllowBlankTitle()
	{
		$make = $this->createMMY('Honda','Civic','2000')->getLevel('make');
		$make->setTitle('')->save();
	}
	
	/**
	* @expectedException Exception
	*/
	function testShouldNotAllowBlankTitle2()
	{
		$make = $this->createMMY('Honda','Civic','2000')->getLevel('make');
		$make->setTitle(' ')->save();
	}
}