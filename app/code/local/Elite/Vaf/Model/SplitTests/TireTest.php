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
class Elite_Vaf_Model_SplitTests_TireTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
	function testShouldDuplicateTire()
    {
        $vehicle = $this->createMMY('Honda','Civic','2000');
        $tireSize = Elite_Vaftire_Model_TireSize::create('205/55-16');
        
        $tireVehicle = new Elite_Vaftire_Model_Vehicle($vehicle);
        $tireVehicle->save();
        $tireVehicle->addTireSize( $tireSize );
        
        $this->split($vehicle, 'year', array('2000','2001'));
        
        $one = $this->vehicleFinder()->findOneByLevels(array('make'=>'Honda', 'model'=>'Civic', 'year'=>'2000'));
        $tireVehicle1 = new Elite_Vaftire_Model_Vehicle($one);
        
        $two = $this->vehicleFinder()->findOneByLevels(array('make'=>'Honda', 'model'=>'Civic', 'year'=>'2000'));
        $tireVehicle2 = new Elite_Vaftire_Model_Vehicle($two);
        
        $one = $tireVehicle1->tireSize();
        $two = $tireVehicle2->tireSize();
        $this->assertEquals( $tireSize, $one[0], 'SPLIT Should copy tire size to each resultant vehicle.' );
        $this->assertEquals( $tireSize, $two[0], 'SPLIT Should copy tire size to each resultant vehicle.' );
    }
    
}