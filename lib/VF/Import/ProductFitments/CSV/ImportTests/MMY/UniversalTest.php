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
class VF_Import_ProductFitments_CSV_ImportTests_MMY_UniversalTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $this->insertProduct( self::SKU );
    }
    
    function testMakesProductUniversal()
    {
        $this->mappingsImport('sku, make, model, year, universal
"sku","","","","1"');
        $this->assertTrue( $this->getProductForSku('sku')->isUniversal() );
    }
        
    
    function testMakesProductUniversal_YearRange()
    {
        $this->mappingsImport('sku, make, model, year_start, year_end, universal
"sku","","","","","1"');
        return $this->markTestIncomplete();
        //$this->assertTrue( $this->getProductForSku('sku')->isUniversal() );
    }
        
    function testDoesNotImportBlankDefinition()
    {
        $this->mappingsImport('sku, make, model, year, universal
"sku","","","","1"');
        
        $vehicleFinder = new VF_Vehicle_Finder(new VF_Schema());
        $vehicles = $vehicleFinder->findAll();
        $this->assertEquals( 0, count($vehicles));
    }
            
    function testDoesNotInsertNullVehicle()
    {
        $this->mappingsImport('sku, make, model, year, universal
"sku","","","","1"');
        
        $vehicleFinder = new VF_Vehicle_Finder(new VF_Schema());
        $count = $this->getReadAdapter()->query('select count(*) from elite_1_definition')->fetchColumn();
        $this->assertEquals( 0, $count);
    }
    
    function testShouldNotLogErrorsForUniversalRecord()
    {
        $importer = $this->mappingsImporterFromData('sku, make, model, year, universal
"sku","","","","1"');
        $importer->import();
        
        $writer = new Zend_Log_Writer_Mock();
        $logger = new Zend_Log($writer);
        $logger->addFilter(new Zend_Log_Filter_Priority(Zend_Log::NOTICE));
        $importer->setLog($logger);
        
        $importer->import();
        
        $this->assertEquals( 0, count($writer->events) );
    }
    
    function testShouldNotTallyInvalidVehicle()
    {
        $importer = $this->mappingsImporterFromData('sku, make, model, year, universal
"sku","","","","1"');
        $importer->import();

        $this->assertEquals( 0, $importer->invalidVehicleCount() );
    }
    
    function testShouldNotTallyInvalidVehicle_YearRange()
    {
        return $this->markTestIncomplete();
        $importer = $this->mappingsImporterFromData('sku, make, model, year_start, year_end, universal
"sku","","","","1"');
        $importer->import();

        $this->assertEquals( 0, $importer->invalidVehicleCount() );
    }
    
}
