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
class VF_Import_ProductFitments_CSV_ExportTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
        
        $this->csvData = 'sku, make, model, year, universal
sku123, honda, civic, 2001
sku456, honda, civic, 2000
sku456,acura,integra,2000
sku123,acura,integra,2004
sku123,acura,test,2002
';
        $this->csvFile = TEMP_PATH . '/mappings-single.csv';
        file_put_contents( $this->csvFile, $this->csvData );
        
        
        $this->insertProduct( 'sku123' );
        $this->insertProduct( 'sku456' );
        
        $importer = new VF_Import_ProductFitments_CSV_Import_TestSubClass( $this->csvFile );
        $importer->import();
    }
    
    function testExport()
    {
        $data = $this->exportProductFitments();
        $output = explode( "\n", $data );
        
        $this->assertEquals( 'sku,universal,make,model,year,notes', $output[0] );
        $this->assertEquals( 'sku123,0,honda,civic,2001,""', $output[1] );
        $this->assertEquals( 'sku456,0,honda,civic,2000,""', $output[2] );
        $this->assertEquals( 'sku456,0,acura,integra,2000,""', $output[3] );
        $this->assertEquals( 'sku123,0,acura,integra,2004,""', $output[4] );
        $this->assertEquals( 'sku123,0,acura,test,2002,""', $output[5] );
    }
    
    function testExportUniversal()
    {
        $data = $this->exportProductFitments();
        $output = explode( "\n", $data );
        $this->assertEquals( 'sku,universal,make,model,year,notes', $output[0] );
    }
       
}
