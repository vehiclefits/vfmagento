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
class VF_Import_ProductFitments_CSV_ImportTests_MMY_AlreadyExistingTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{    
    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $this->csvData = 'sku, make, model, year' . "\n" .
                         'sku, honda, civic, 2000';
        
        $this->insertProduct('sku');
    }
    
    function testNonExistantSku_ShouldNotAffectSkippedCount()
    {
        $importer = $this->mappingsImporterFromData('sku, make, model, year' . "\n" .
                                                    'nonexist, honda, civic, 2000');
        $importer->import();
        $this->assertEquals( 0, $importer->getCountSkippedMappings(), 'non existant sku should NOT affect skipped count' );
    }
    
    function testSkippedCountIs0AfterSuccess()
    {
        $importer = $this->mappingsImporterFromData($this->csvData);
        $importer->import();
        $this->assertEquals( 0, $importer->getCountSkippedMappings() );
    }
    
    function testSkippedCountIs1IfFitAlreadyExists()
    {
        $importer = $this->mappingsImporterFromData($this->csvData);
        $importer->import();
        
        $importer = $this->mappingsImporterFromData($this->csvData);
        $importer->import();
        
        $this->assertEquals( 1, $importer->getCountSkippedMappings() );
    }
     
    function testSkippedCountIs1IfFitAlreadyExists_Multiple()
    {
        $csvData = 'sku, make, model, year' . "\n" .
                         'sku, honda, civic2, 2000' . "\n";
                         'sku2, honda, integra, 2000';
                         
        $importer = $this->mappingsImporterFromData($csvData);
        $importer->import();
        
        $importer = $this->mappingsImporterFromData($csvData);
        $importer->import();
        
        $this->assertEquals( 1, $importer->getCountSkippedMappings() );
    }
        
    
    function testShouldNotCountExistingFitments()
    {
        $this->insertProduct('sku1');
        $productId = $this->insertProduct('sku2');
        
        $vehicle = $this->createMMY('Doesnt Fit', 'Doesnt Fit', 'doesnt fit');
        $this->insertMappingMMY($vehicle, $productId);
        
        $csvData = 'sku, make, model, year' . "\n" .
                   'sku1, honda, civic2, 2000';
                         
        $importer = $this->mappingsImporterFromData($csvData);
        $importer->import();
        
        $this->assertEquals( 0, $importer->getCountSkippedMappings() );
    }
    
    function testShouldNotCountDifferentFitments()
    {
        $productId = $this->insertProduct('sku1');
        $vehicle = $this->createMMY('honda', 'Doesnt Fit', 'doesnt fit');
        $this->insertMappingMMY($vehicle, $productId);
        
        $csvData = 'sku, make, model, year' . "\n" .
                   'sku1, honda, civic2, 2000';
                         
        $importer = $this->mappingsImporterFromData($csvData);
        $importer->import();
        
        $this->assertEquals( 0, $importer->getCountSkippedMappings() );
    }
        
    
}