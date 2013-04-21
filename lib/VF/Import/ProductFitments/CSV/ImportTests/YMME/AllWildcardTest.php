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
class VF_Import_ProductFitments_CSV_ImportTests_YMME_AllWildcardTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{    
    protected $product_id;
    
    protected function doSetUp()
    {
        $this->switchSchema('year,make,model,engine');        
        $this->product_id = $this->insertProduct('sku');
    }
    
    function testShouldMakeSafeOperations()
    {
        $this->createVehicle(array('year'=>2000, 'make'=>'Ford', 'model'=>'F-150', 'engine'=>'1.6L'));
        $this->createVehicle(array('year'=>2000, 'make'=>'Ford', 'model'=>'F-150', 'engine'=>'1.8L'));
        
        $this->createVehicle(array('year'=>2001, 'make'=>'Ford', 'model'=>'F-150', 'engine'=>'1.6L'));
        // there is no 2001/Ford/F-150 with a 1.8L in this example
        
        $this->mappingsImport('sku, make, model, year, engine' . "\n" .
                              'sku,Ford,F-150,"2000,2001,2002",{{all}}');
        
        $product = new Elite_Vaf_Model_Catalog_Product();
        $product->setId($this->product_id);
        $fits = $product->getFits();
        
        $this->assertEquals( 3, count($fits), 'should not a non-existant vehicle even it is implied' );
    }
        

}
