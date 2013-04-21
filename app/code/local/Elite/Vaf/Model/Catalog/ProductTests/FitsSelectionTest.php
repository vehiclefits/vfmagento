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
class Elite_Vaf_Model_Catalog_ProductTests_FitsSelectionTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{
    function testFits()
    {
        $product = $this->getProduct(1);
        $vehicle = $this->createMMY();
        $this->insertMappingMMY($vehicle,1);
        $this->assertTrue($product->fitsVehicle($vehicle), 'product should fit vehicle');
    }

    function testFitsSelection()
    {
        $product = $this->getProduct(1);
        $vehicle = $this->createMMY();
        $this->insertMappingMMY($vehicle,1);
        $this->setSelectedFit($vehicle);
        $product->setCurrentlySelectedFit($vehicle);
        $this->assertTrue($product->fitsSelection(), 'product should fit selection');
    }

    function testWhenNoSelection()
    {
        $product = $this->getProduct(1);
        $vehicle = $this->createMMY();
        $this->insertMappingMMY($vehicle,1);
        $this->assertFalse($product->fitsSelection(), 'when there is no selection, product should not fit selection');
    }

    function testDoesntFitSelection()
    {
        $product = $this->getProduct(1);
        $vehicle = $this->createMMY('honda','civic','2001');
        $vehicle2 = $this->createMMY('honda','civic','2002');
        $this->insertMappingMMY($vehicle,1);
        $this->setSelectedFit($vehicle2);
        $product->setCurrentlySelectedFit($vehicle2);
        $this->assertFalse($product->fitsSelection(), 'product should not fit selection');
    }

    function setSelectedFit($vehicle)
    {
        Elite_Vaf_Helper_Data::getInstance()->getRequest()->setParams($vehicle->toValueArray());
    }
}
