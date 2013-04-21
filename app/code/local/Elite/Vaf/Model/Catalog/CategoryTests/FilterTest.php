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
class Elite_Vaf_Model_Catalog_CategoryTests_FilterTest extends Elite_Vaf_Model_Catalog_CategoryTests_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testDoesNotFilterWhenNoVehicleSelected()
    {
        $category = $this->getCategory();
        $category->getProductCollection();
        $this->assertFalse( $category->filtered, 'when there is no vehicle selected, it will not filter' );
    }

    function testDoesFilterWhenVehicleSelected()
    {
        $this->filterOnAMMY();
        $category = $this->getCategory();
        $category->getProductCollection();
        $this->assertTrue( $category->filtered, 'when there is a vehicle selected, it will filter' );
    }
    
    function testWhenFilterIsTrueWillFilter()
    {
        $this->filterOnAMMY();
        $category = $this->categoryFilterWillReturn( true );
        $category->getProductCollection();
        $this->assertTrue( $category->filtered, 'when the filter says to filter, the category WILL filter the products' );
    }
    
    function testWhenFilterIsFalseWillNotFilter()
    {
        $this->filterOnAMMY();
        $category = $this->categoryFilterWillReturn( false );
        $category->getProductCollection();
        $this->assertFalse( $category->filtered, 'when the filter says NOT to filter, the category WILL NOT filter the products' );
    }

}