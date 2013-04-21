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
class VF_Import_VehiclesList_CSV_ImportTests_MMY_DashTest extends VF_Import_TestCase
{

    protected $csvData;
    protected $csvFile;

    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function test1()
    {
        $this->importVehiclesList('make, model, year
honda, ci-vic, 2000
honda, ci-vic, 2001');
        $finder = new VF_Vehicle_Finder(new VF_Schema());
        $vehicles = $finder->findByLevels(array('make'=>'honda', 'model'=>'ci-vic', 'year'=>'2000' ));
        $this->assertEquals(1,count($vehicles));
    }
    
    function test2()
    {
        $this->importVehiclesList('make, model, year
honda, ci-vic, 2000
honda, ci-vic, 2001');
		$finder = new VF_Vehicle_Finder(new VF_Schema());
        $vehicles = $finder->findByLevels(array('make'=>'honda', 'model'=>'ci-vic', 'year'=>'2001' ));
        $this->assertEquals(1,count($vehicles));
    }
    
    function test3()
    {
        $this->importVehiclesList('make, model, year
honda, ci-vic, 2000
honda, ci-vic, 2001');
		$finder = new VF_Vehicle_Finder(new VF_Schema());
        $result = $this->query('select count(*) from elite_1_definition;');
        $this->assertEquals(2,$result->fetchColumn());
    }
    
    function test4()
    {
        $this->importVehiclesList('make, model, year
honda, ci-vic, 2000
honda, civi-c, 2000');
		$finder = new VF_Vehicle_Finder(new VF_Schema());
        $result = $this->query('select count(*) from elite_1_definition;');
        $this->assertEquals(2,$result->fetchColumn());
    }

}