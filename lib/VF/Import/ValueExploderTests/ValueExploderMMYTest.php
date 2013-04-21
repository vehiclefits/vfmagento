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
class VF_Import_ValueExploderMMYTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');        
        
        $this->product_id = $this->insertProduct('sku');
    }
    
    function testExplodeValues()
    {
        
        $valueExploder = new VF_Import_ValueExploder;
        $this->importDefinitions();
        
        $result = $valueExploder->explode( array('make'=>'honda','model'=>'{{all}}','year'=>2000) );
        
        $this->assertEquals( 2, count($result), 'value exploder should explode single token' );
        $this->assertEquals( array('make'=>'honda','model'=>'civic','year'=>2000), $result[0] );
        $this->assertEquals( array('make'=>'honda','model'=>'accord','year'=>2000), $result[1] );
    }
    
    function testExplodeValuesMultiple()
    {
        
        $valueExploder = new VF_Import_ValueExploder;
        $this->importDefinitions();
        
        $result = $valueExploder->explode( array('make'=>'honda','model'=>'{{all}}','year'=>'{{all}}') );
        
        $this->assertEquals( 3, count($result), 'value exploder should explode multiple tokens' );
        $this->assertEquals( array('make'=>'honda','model'=>'civic','year'=>2000), $result[0] );
        $this->assertEquals( array('make'=>'honda','model'=>'civic','year'=>2001), $result[1] );
        $this->assertEquals( array('make'=>'honda','model'=>'accord','year'=>2000), $result[2] );
    }
    
    protected function importDefinitions()
    {
        $importer = $this->vehiclesListImporter( 'make, model, year
honda, civic, 2000
honda, accord, 2000
honda, civic, 2001.
not honda, whatev, 2000' );
        $importer->import();
    }
}