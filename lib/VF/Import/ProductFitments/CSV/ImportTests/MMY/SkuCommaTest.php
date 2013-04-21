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
class VF_Import_ProductFitments_CSV_ImportTests_MMY_SkuCommaTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $this->csvData = 'sku, make, model, year
"sku1,sku2", honda, civic, 2000';
        
        $this->insertProduct('sku1');
        $this->insertProduct('sku2');
        $this->insertProduct('ZZZ');
    }
    
    function testShouldMatchSku1()
    {
        $this->mappingsImport($this->csvData);
        $fit = $this->getFitForSku('sku1');
        $this->assertEquals( 'honda', $fit->getLevel('make')->getTitle() );
    }
    
    function testShouldMatchSku2()
    {
        $this->mappingsImport($this->csvData);
        $fit = $this->getFitForSku('sku2');
        $this->assertEquals( 'honda', $fit->getLevel('make')->getTitle() );
    }
    
  
    function testShouldNotMatchZZZ()
    {
        $this->mappingsImport($this->csvData);
        $fit = $this->getFitForSku('ZZZ');
        $this->assertFalse( $fit );
    }
    
  
}
