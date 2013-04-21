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
class VF_Import_ProductFitments_CSV_ImportTests_MMY_NonExistantSkusTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testWhenOneRow_ShouldReportSingleMissingSKU()
    {
        $importer = $this->mappingsImporterFromData(
            'sku, make, model, year' . "\n" .
            'nonexistantsku, honda, civic, 2000');
        $importer->import();
        $this->assertEquals( array( 'nonexistantsku' ), $importer->nonExistantSkus(), 'should report a single missing SKU' );
    }
    
    function testShouldNotCreateFitmentForMissingSKU()
    {
        $importer = $this->mappingsImporterFromData(
            'sku, make, model, year' . "\n" .
            'nonexistantsku, honda, civic, 2000');
        $importer->import();
        $count = $this->getReadAdapter()->query('select count(*) from elite_1_mapping where entity_id=0')->fetchColumn();
        $this->assertEquals(0,$count);
    }
    
    function testWhenUsingYearRanges_ShouldReportSingleMissingSKU()
    {
        return $this->markTestIncomplete();
    }
    
    function testWhenMultipleRowsSameSku_ShouldReportSingleSKU()
    {
        $importer = $this->mappingsImporterFromData(
            'sku, make, model, year' . "\n" .
            'nonexistantsku, honda, civic, 2000' . "\n" .
            'nonexistantsku, honda, civic, 2001');
        $importer->import();
        $this->assertEquals( array( 'nonexistantsku' ), $importer->nonExistantSkus(), 'when multiple rows with the same SKU, should report one missing SKU' );
    }

    function testShouldCountErrorsNotSKUs()
    {
        $importer = $this->mappingsImporterFromData(
            'sku, make, model, year' . "\n" .
            'nonexistantsku, honda, civic, 2000' . "\n" .
            'nonexistantsku, honda, civic, 2001');
        $importer->import();
        $this->assertEquals( 2, $importer->nonExistantSkusCount(), 'should count the errors not the SKUs' );
    }
    
    function testShouldLogMissingSku()
    {
        $importer = $this->mappingsImporterFromData(
            'sku,make,model,year' . "\n" . 
            'sku1,honda,civic,2000');
        
        $writer = new Zend_Log_Writer_Mock();
        $logger = new Zend_Log($writer);
        $logger->addFilter(new Zend_Log_Filter_Priority(Zend_Log::NOTICE));
        $importer->setLog($logger);
        
        $importer->import();
        
        $event = $writer->events[0];
        $this->assertEquals( 'Line(1) Non Existant SKU \'sku1\'', $event['message'] );
    }

    function testShouldLogMissingSku_CorrectLineNumber()
    {
        $importer = $this->mappingsImporterFromData(
            'sku,make,model,year' . "\n" . 
            'sku1,honda,civic,2000' . "\n" .
            'sku2,honda,civic,2000');
        
        $writer = new Zend_Log_Writer_Mock();
        $logger = new Zend_Log($writer);
        $logger->addFilter(new Zend_Log_Filter_Priority(Zend_Log::NOTICE));
        $importer->setLog($logger);
        
        $importer->import();
        
        $event = $writer->events[1];
        $this->assertEquals( 'Line(2) Non Existant SKU \'sku2\'', $event['message'] );
    }
    
    function testShouldLogMissingSkuOncePerLine()
    {
        $importer = $this->mappingsImporterFromData(
            'sku,make,model,year_range' . "\n" . 
            'sku1,honda,civic,2000-2001');
        
        $writer = new Zend_Log_Writer_Mock();
        $logger = new Zend_Log($writer);
        $logger->addFilter(new Zend_Log_Filter_Priority(Zend_Log::NOTICE));
        $importer->setLog($logger);
        
        $importer->import();
        $this->assertEquals( 1, count($writer->events) );
    }
    
    function testWhenUsingYearRanges_ShouldReportSingleRowWithMissingSKU()
    {
        $data = 'sku, make, model, year_start,year_end
nonexistantsku, honda, civic, 2000,2001';
        
        $importer = $this->mappingsImporterFromData($data);
        $importer->import();
        $this->assertEquals( 1, $importer->rowsWithNonExistantSkus(), 'row count with invalid SKUs should be 1 even if multiple years' );
    }

    function testTwoNonExistantSku()
    {
        $vehicle = $this->createMMY('Doesnt Fit', 'Doesnt Fit', 'doesnt fit');
        $this->insertMappingMMY($vehicle, 1);
        
        $importer = $this->mappingsImporterFromData('sku, make, model, year' . "\n" .
                                                    'nonexist, honda, civic, 2000
                                                    nonexist2, honda, civic, 2001');
        $importer->import();
        $this->assertEquals( 2, $importer->nonExistantSkusCount(), 'non existant sku should NOT affect skipped count' );
    }

    function testTwoNonExistantSku2()
    {
        return $this->markTestIncomplete();
        
        $vehicle = $this->createMMY('Doesnt Fit', 'Doesnt Fit', 'doesnt fit');
        $this->insertMappingMMY($vehicle, 1);
        
        $importer = $this->mappingsImporterFromData('sku, make, model, year' . "\n" .
                                                    'nonexist, acura, civic, 2000
                                                    nonexist, honda, civic, 2000');
        $importer->import();
        $this->assertEquals( 1, $importer->nonExistantSkusCount(), 'should only count one non-existant sku' );
    }

}