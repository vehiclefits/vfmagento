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
class VF_Import_ProductFitments_CSV_ImportTests_YMM_SimpleTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema( 'year,make,model' );
        
        $this->csvData = 'sku, make, model, year
sku, honda, civic, 2000';
        
        $this->insertProduct( self::SKU );
    }

    function testSku()
    {
        $this->mappingsImport( $this->csvData );
        $fit = $this->getFitForSku( self::SKU );
        $this->assertEquals( 'honda', $fit->getLevel( 'make' )->getTitle() );
    }
    
    function testMake()
    {
        $this->mappingsImport( $this->csvData );
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda')), 'importer should be able to load makes (root levels) properly' );
    }
    
    function testCountMappingsIs1AfterSuccess()
    {
        $importer = $this->mappingsImporterFromData( $this->csvData );
        $importer->import();
        $this->assertEquals( 1, $importer->getCountMappings() );
    }    

//    function testSkippedCountIs1IfFitAlreadyExists()
//    {
//        $importer = new VF_Import_ProductFitments_CSV_Import_TestSubClass( $this->csvFile );
//        $importer->import();
        // execise ( again)
//        $importer = new VF_Import_ProductFitments_CSV_Import_TestSubClass( $this->csvFile );
//        $importer->import();
//        $this->assertEquals( 1, $importer->getCountSkippedMappings() );
//    }
    
}