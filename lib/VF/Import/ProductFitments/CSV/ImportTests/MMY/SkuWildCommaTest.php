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
class VF_Import_ProductFitments_CSV_ImportTests_MMY_SkuWildCommaTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $this->csvData = 'sku, make, model, year
"aaa*,bbb*", honda, civic, 2000';
        
        $this->insertProduct('aaa1');
        $this->insertProduct('aaa2');
        $this->insertProduct('bbb1');
        $this->insertProduct('bbb2');
        $this->insertProduct('ZZZ');
    }
    
    function testShouldMatchAAA1()
    {
        $this->mappingsImport($this->csvData);
        $fit = $this->getFitForSku('aaa1');
        $this->assertEquals( 'honda', $fit->getLevel('make')->getTitle() );
    }

    function testShouldMatchAAA2()
    {
        $this->mappingsImport($this->csvData);
        $fit = $this->getFitForSku('aaa1');
        $this->assertEquals( 'honda', $fit->getLevel('make')->getTitle() );
    }

    function testShouldMatchBBB1()
    {
        $this->mappingsImport($this->csvData);
        $fit = $this->getFitForSku('aaa1');
        $this->assertEquals( 'honda', $fit->getLevel('make')->getTitle() );
    }

    function testShouldMatchBBB2()
    {
        $this->mappingsImport($this->csvData);
        $fit = $this->getFitForSku('bbb2');
        $this->assertEquals( 'honda', $fit->getLevel('make')->getTitle() );
    }


  
    function testShouldNotMatchZZZ()
    {
        $this->mappingsImport($this->csvData);
        $fit = $this->getFitForSku('ZZZ');
        $this->assertFalse( $fit );
    }
    
  
}
