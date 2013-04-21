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
class VF_Import_ProductFitments_CSV_ImportTests_MMY_NoVehicletest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $this->insertProduct('sku');
    }

    function testShouldNotIncrementSkippedCount()
    {
        $importer = $this->mappingsImporterFromData('sku,make,model,year' . "\n" .
                                                    'sku,,,');
        $importer->import();
        $this->assertEquals(0, $importer->getCountSkippedMappings(), 'should not increment skipped count when there is no vehicle');
    }
    
    function testShouldIncrementInvalidVehicleCount()
    {
        $importer = $this->mappingsImporterFromData('sku,make,model,year' . "\n" .
                                                    'sku,,,');
        $importer->import();
        $this->assertEquals(1, $importer->invalidVehicleCount(), 'should increment invalid vehicle count when there is no vehicle');
    }
    
    function testShouldIncrementInvalidVehicleCount2()
    {
        $importer = $this->mappingsImporterFromData('sku,make,model,year' . "\n" .
                                                    'sku,make,,year');
        $importer->import();
        $this->assertEquals(1, $importer->invalidVehicleCount(), 'should increment invalid vehicle count when there is no vehicle');
    }
    
    function testShouldNotIncrementInvalidVehicleCountForUniversal()
    {
        $importer = $this->mappingsImporterFromData('sku,make,model,year,universal' . "\n" .
                                                    'sku,,,,1');
        $importer->import();
        $this->assertEquals(0, $importer->invalidVehicleCount(), 'should not increment invalid vehicle count when universal fitment');
    }
}