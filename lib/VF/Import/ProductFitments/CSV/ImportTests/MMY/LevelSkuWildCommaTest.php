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
class VF_Import_ProductFitments_CSV_ImportTests_MMY_LevelSkuWildCommaTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{    
    protected $f150, $f250, $foo;
    protected $product_1, $product_2, $product_3;
    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
        
        $this->f150 = $this->createMMY('Ford','F-150','2000');
        $this->f250 = $this->createMMY('Ford','F-250','2000');
        $this->foo = $this->createMMY('Ford','foo','2000');
        
        $this->csvData = 'sku, make, model, year
"aaa*,bbb*", Ford, "F-*,foo", 2000';
        
        $this->product_1 = $this->insertProduct('aaa1');
        $this->product_2 = $this->insertProduct('aaa2');
        $this->product_3 = $this->insertProduct('bbb1');
        $this->insertProduct('bbb2');
        $this->insertProduct('ZZZ');
    }
    
    function testF150ShouldFitAAA1()
    {
        $this->mappingsImport($this->csvData);
        $fits = $this->newProduct($this->product_1)->getFits();
        $this->assertEquals( 'F-150', $fits[0]->model, 'level wild card and sku wild card should inter-operate' );
    }
    
    function testF250ShouldFitAAA1()
    {
        $this->mappingsImport($this->csvData);
        $fits = $this->newProduct($this->product_1)->getFits();
        $this->assertEquals( 'F-250', $fits[1]->model, 'level wild card and sku wild card should inter-operate' );
    }

    function testF150ShouldFitAAA2()
    {
        $this->mappingsImport($this->csvData);
        $fits = $this->newProduct($this->product_2)->getFits();
        $this->assertEquals( 'F-150', $fits[0]->model, 'level wild card and sku wild card should inter-operate' );
    }
    
    function testF250ShouldFitAAA2()
    {
        $this->mappingsImport($this->csvData);
        $fits = $this->newProduct($this->product_2)->getFits();
        $this->assertEquals( 'F-250', $fits[1]->model, 'level wild card and sku wild card should inter-operate' );
    }
    
    function testF150ShouldFitBBB1()
    {
        $this->mappingsImport($this->csvData);
        $fits = $this->newProduct($this->product_3)->getFits();
        $this->assertEquals( 'F-150', $fits[0]->model, 'level wild card and sku enumeration should inter-operate' );
    }
    
    function testF250ShouldFitBBB1()
    {
        $this->mappingsImport($this->csvData);
        $fits = $this->newProduct($this->product_3)->getFits();
        $this->assertEquals( 'F-250', $fits[1]->model, 'level wild card and sku enumeration should inter-operate' );
    }

    function testFooShouldFitAAA1()
    {
        $this->mappingsImport($this->csvData);
        $fits = $this->newProduct($this->product_1)->getFits();
        $this->assertEquals( 'foo', $fits[2]->model, 'level enumeration and sku wildcard should inter-operate' );
    }
    
    function testFooShouldFitAAA2()
    {
        $this->mappingsImport($this->csvData);
        $fits = $this->newProduct($this->product_2)->getFits();
        $this->assertEquals( 'foo', $fits[2]->model, 'level enumeration and sku wildcard should inter-operate' );
    }
    
    function testFooShouldFitBBB1()
    {
        $this->mappingsImport($this->csvData);
        $fits = $this->newProduct($this->product_3)->getFits();
        $this->assertEquals( 'foo', $fits[2]->model, 'level enumeration and sku wildcard should inter-operate' );
    }

}