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
class VF_Import_VehiclesList_CSV_ImportTests_YMM_DuplicateTest extends VF_Import_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('year,make,model',true);
    }
    
    function testShouldStoreMakesUnderCorrectYear()
    {
        $this->importVehiclesList('"year","make","model",
"1990","STIHL","39",
"1991","STIHL","39",');

        $y1990 = $this->levelFinder()->findEntityIdByTitle('year','1990');
        $makes = $this->levelFinder()->listAll('make', $y1990);
        $this->assertEquals( 1, count($makes), 'should store makes under correct year');
    }
    
    function testShouldImportMakesOnlyOnce()
    {
        $this->importVehiclesList('"year","make","model",
"1990","STIHL","39",
"1990","STIHL","base",');

        $y1990 = $this->levelFinder()->findEntityIdByTitle('year','1990');
        $makes = $this->levelFinder()->listAll('make', $y1990);
        $this->assertEquals( 1, count($makes), 'should store makes under correct year');
    }
}