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
 * to sales@vehiclefits.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Elite_Vaf_Model_Catalog_ProductTests_ProductTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{

    function testSetDataShouldSetWrappedProductsIdArray()
    {
        $product = new Elite_Vaf_Model_Catalog_Product;
        $product->setData(array('id'=>4));
        $this->assertEquals(4,$product->VFProduct()->getId(), "setData() should set the wrapped VF_Product's ID");
    }

    function testSetDataShouldSetWrappedProductsId()
    {
        $product = new Elite_Vaf_Model_Catalog_Product;
        $product->setData('id',4);
        $this->assertEquals(4,$product->VFProduct()->getId(), "setData() should set the wrapped VF_Product's ID");
    }

    function testSetDataShouldSetWrappedEntityId()
    {
        $product = new Elite_Vaf_Model_Catalog_Product;
        $product->setData('entity_id',4);
        $this->assertEquals(4,$product->VFProduct()->getId(), "setData() should set the wrapped VF_Product's ID");
    }

    function testSetDataShouldBeChainable()
    {
        $product = new Elite_Vaf_Model_Catalog_Product;
        $product->setData(array('id'=>4))
                ->setData(array('id'=>5));
        $this->assertEquals(5,$product->VFProduct()->getId(), "setData() should be chainable");
    }

    function testSetDataShouldWorkWithNoID()
    {
        $product = new Elite_Vaf_Model_Catalog_Product;
        $product->setData(array());
    }

    function testGetOrderBy()
    {
        $product = $this->getProduct();
        $this->assertEquals( '`make`,`model`,`year`', $product->getOrderBy() );
    }

}