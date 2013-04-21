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
class VF_Import_VehiclesList_CSV_ImportTests_MMY_CommaTest extends VF_Import_TestCase
{    
    protected $product_id;
    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');        
    }
    
    function testComma()
    {
        $importer = $this->vehiclesListImporter('"make", "model", "year"
"honda", "accord,civic", "2000,2003"');
        $importer->import();

        $vehicleFinder = new VF_Vehicle_Finder( new VF_Schema );
        $vehicles = $vehicleFinder->findByLevels( array('make'=>'honda') );
                              
        $this->assertEquals( 4, count($vehicles), 'should enumerate out options' );
        $this->assertEquals( 'honda accord 2000', $vehicles[0]->__toString() );
        $this->assertEquals( 'honda accord 2003', $vehicles[1]->__toString() );        
        $this->assertEquals( 'honda civic 2000', $vehicles[2]->__toString() );        
        $this->assertEquals( 'honda civic 2003', $vehicles[3]->__toString() );        
    }

    function testCommaWithSpaces()
    {
        $importer = $this->vehiclesListImporter('"make", "model", "year"
"honda", "accord, civic", "2000,2003"');
        $importer->import();

        $vehicleFinder = new VF_Vehicle_Finder( new VF_Schema );
        $this->assertTrue($this->vehicleExists(array('make'=>'honda', 'model'=>'civic','year'=>'2000')));
    }

    function testShouldEscapeComma()
    {
        $importer = $this->vehiclesListImporter('"make", "model", "year"
"honda", "accord,, test, civic", "2000,2003"');
        $importer->import();

        $vehicleFinder = new VF_Vehicle_Finder( new VF_Schema );
        $this->assertTrue($this->vehicleExists(array('make'=>'honda', 'model'=>'accord, test','year'=>'2000')));
    }

    
}