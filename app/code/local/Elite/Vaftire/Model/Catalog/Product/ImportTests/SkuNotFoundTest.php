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
class Elite_Vaftire_Model_Catalog_Product_ImportTests_SkuNotFoundTest extends Elite_Vaftire_Model_Catalog_Product_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testShouldSkipNotFoundSku()
    {
        $this->importVehicleTireSizes("make,model,year,tire_size\n".
                                      "honda,civic,2002,205/55-16");
        $this->import('"sku","section_width","aspect_ratio","diameter","tire_type"' . "\n" .
                      '"doesnt_exist","205","55","16","2"');
        
    }
    
    function importVehicleTireSizes($stringData)
    {
        $file = TEMP_PATH . '/vehicle-tire-sizes.csv';
        file_put_contents( $file, $stringData );
        $importer = new Elite_Vaftire_Model_Importer_Definitions_TireSize($file);
        $importer->import();
    }
    
    function import($stringData)
    {
        $stringData = '"sku","section_width","aspect_ratio","diameter","tire_type"
"sku9846546546465465","205","55","16","2"';
        $file = TEMP_PATH . '/product-tire-sizes.csv';
        file_put_contents( $file, $stringData );
        $importer = $this->importer( $file );
        $importer->import();
    }
   
}