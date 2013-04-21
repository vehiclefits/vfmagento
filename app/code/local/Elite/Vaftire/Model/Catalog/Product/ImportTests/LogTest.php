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
class Elite_Vaftire_Model_Catalog_Product_ImportTests_LogTest extends Elite_Vaftire_Model_Catalog_Product_ImportTests_TestCase
{    
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $this->csvData = '"sku","section_width","aspect_ratio","diameter","tire_type"
"sku","205","55","16","2"';
        $this->csvFile = TEMP_PATH . '/product-tire-sizes.csv';
        file_put_contents( $this->csvFile, $this->csvData );
        
        $this->insertProduct('sku');
    }
    
    function testShouldLogAssignmentOfTireSizeToProduct()
    {
        $writer = new Zend_Log_Writer_Mock();
        $logger = new Zend_Log($writer);
        
        $importer = $this->importer( $this->csvFile );
        $importer->setLog($logger);
        $importer->import();
        
        $event = $writer->events[0];
        $this->assertEquals("Assigned tire size [205/55-16] to sku [sku]", $event['message'] );
    }
    
    function testShouldLogAssignmentOfVehicleToProduct()
    {
        
    }
}