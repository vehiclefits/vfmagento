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
class Elite_Vafnote_Observer_Exporter_Mappings_CSVTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{    
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
        
        $this->createNoteDefinition('code1','foo');
        $this->createNoteDefinition('code2','bar');
        $this->csvData = 'sku, make, model, year, notes
sku, honda, civic, 2000, "code1,code2"';
        $this->csvFile = TEMP_PATH . '/mappings-single.csv';
        file_put_contents( $this->csvFile, $this->csvData );
        
        $this->insertProduct('sku');
    }
    
    function testNotes()
    {       
        $importer = new VF_Import_ProductFitments_CSV_Import_TestSubClass( $this->csvFile );
        $importer->import();
        $data = $this->exportProductFitments();
        $string = explode("\n",$data);
        $this->assertEquals( "sku,universal,make,model,year,notes", $string[0] );
        $this->assertEquals( "sku,0,honda,civic,2000,\"code1,code2\"", $string[1] );
    }
    
}

class VF_Import_ProductFitmentsExport_TestStub extends VF_Import_ProductFitments_CSV_Export
{
    protected function getProductTable()
    {
        return 'test_catalog_product_entity';
    }
}