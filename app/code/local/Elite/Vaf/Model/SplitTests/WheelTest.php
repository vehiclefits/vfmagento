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
class Elite_Vaf_Model_SplitTests_WheelsTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
	function testShouldDuplicateWheel()
    {
        $vehicle = $this->createMMY('Honda','Civic','2000');
        
        $wheelVehicle = new Elite_Vafwheel_Model_Vehicle($vehicle);
        $wheelVehicle->save();
        $wheelVehicle->addBoltPattern( $this->boltPattern('4x114.3') );
        
        $this->split($vehicle, 'year', array('2000','2001'));
        
        $one = $this->vehicleFinder()->findOneByLevels(array('make'=>'Honda', 'model'=>'Civic', 'year'=>'2000'));
        $wheelVehicle1 = new Elite_Vafwheel_Model_Vehicle($one);
        
        $two = $this->vehicleFinder()->findOneByLevels(array('make'=>'Honda', 'model'=>'Civic', 'year'=>'2000'));
        $wheelVehicle2 = new Elite_Vafwheel_Model_Vehicle($two);
        
        $this->assertEquals( 4, $wheelVehicle1->boltPattern()->lug_count, 'SPLIT Should copy wheel (bolt pattern) to each resultant vehicle.' );
        $this->assertEquals( 114.3, $wheelVehicle1->boltPattern()->bolt_distance, 'SPLIT Should copy wheel (bolt pattern) to each resultant vehicle.' );
        
        $this->assertEquals( 4, $wheelVehicle2->boltPattern()->lug_count, 'SPLIT Should copy wheel (bolt pattern) to each resultant vehicle.' );
        $this->assertEquals( 114.3, $wheelVehicle2->boltPattern()->bolt_distance, 'SPLIT Should copy wheel (bolt pattern) to each resultant vehicle.' );
    }
    
}