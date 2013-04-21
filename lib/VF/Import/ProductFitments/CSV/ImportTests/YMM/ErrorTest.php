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
class VF_Import_ProductFitments_CSV_ImportTests_YMM_ErrorTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema( 'year,make,model' );
        
        $this->csvData = 'sku, make, model, year
sku, honda, civic, 2000';
        
        $this->insertProduct( self::SKU );
    }
    
    function testNonExistantSku()
    {
        $data = 'sku, make, model, year
nonexistantsku, honda, civic, 2000';
        
        $importer = $this->mappingsImporterFromData($data);
        $importer->import();
        $this->assertEquals( array('nonexistantsku'), $importer->nonExistantSkus() );
    }
    
    function testRowsWithNonExistantSkus()
    {
        $data = 'sku, make, model, year
nonexistantsku, honda, civic, 2000';
        
        $importer = $this->mappingsImporterFromData($data);
        $importer->import();
        $this->assertEquals( 1, $importer->rowsWithNonExistantSkus(), 'should count the number of rows with non-existant SKUs' );
    }
    
    function testRowsWithNonExistantSkus_ShouldBe1OneWithYearRanges()
    {
        $data = 'sku, make, model, year_start,year_end
nonexistantsku, honda, civic, 2000,2001';
        
        $importer = $this->mappingsImporterFromData($data);
        $importer->import();
        $this->assertEquals( 1, $importer->rowsWithNonExistantSkus(), 'row count with invalid SKUs should be 1 even if multiple years' );
    }
    
    function testSkippedCountIs0AfterSuccess()
    {
        $importer = $this->mappingsImporterFromData( $this->csvData );
        $importer->import();
        $this->assertEquals( 0, $importer->getCountSkippedMappings() );
    }

}