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
class VF_Import_ProductFitments_CSV_ImportTests_MMY_LevelWildcardTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $this->insertProduct('sku');
    }
    
    function testShouldFindPossibleVehicles()
    {
        $this->createMMY('Ford', 'F150', '2000');
        $this->createMMY('Ford', 'F250', '2000');
        
        $importer = $this->mappingsImporterFromData('sku,make,model,year' . "\n" .
                                                    'sku,Ford,F*,2000');
        $importer->import();
        $this->assertEquals(2, $importer->getCountMappings(), 'should find possible vehicles for fitment');
    }
        
    function testShouldFindPossibleVehicles2()
    {
        $this->createMMY('Ford', 'F-150', '2000');
        $this->createMMY('Ford', 'F-150 Super Duty', '2000');
        $this->createMMY('Ford', 'F-250', '2000');
        $this->createMMY('Ford', 'F-250 Super Duty', '2000');
        
        $importer = $this->mappingsImporterFromData('sku,make,model,year' . "\n" .
                                                    'sku,Ford,F*,2000');
        $importer->import();
        $this->assertEquals(4, $importer->getCountMappings(), 'should find possible vehicles for fitment');
    }
    
    function testShouldNotAddInvalidVehicle()
    {
        $this->createMMY('Ford', 'F-150', '2000');
        $this->createMMY('Ford', 'F-150', '2001');
        $this->createMMY('Ford', 'F-250', '2001');
        
        $importer = $this->mappingsImporterFromData('sku,make,model,year' . "\n" .
                                                    'sku,Ford,F*,"2000,2001"');
        $importer->import();
        $this->assertEquals(3, $importer->getCountMappings(), 'should not add f-250 for 2000');
    }
    

}