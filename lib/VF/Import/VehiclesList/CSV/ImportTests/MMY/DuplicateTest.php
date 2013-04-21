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
class VF_Import_VehiclesList_CSV_ImportTests_MMY_DuplicateTest extends VF_Import_TestCase
{

    protected $csvData;

    function doSetUp()
    {
        $this->switchSchema('make,model,year',true);
        
        $this->csvData = '"year","make","model","option","category","subcategory","country"
"1990","STIHL","39","Base","Chainsaw","Lawn & Garden","USA"
"1991","STIHL","39","Base","Chainsaw","Lawn & Garden","USA"
"1995","STIHL","39","Base","Chainsaw","Lawn & Garden","USA"
"1997","STIHL","39","Base","Chainsaw","Lawn & Garden","USA"';
    }
    
    function testShouldSkipDuplicateVehicles()
    {
        $this->createVehicle(array('make'=>'STIHL','model'=>'39','year'=>1997));
        
        $this->importVehiclesList($this->csvData);
        
        $this->assertEquals( 'STIHL', $this->levelFinder()->findEntityByTitle('make','STIHL')->getTitle(), 'should skip duplicate vehicles' );
        $this->assertTrue( $this->vehicleExists(array('make'=>'STIHL', 'model'=>'39', 'year'=>'1997')), 'should skip duplicate vehicles' );
    }

}