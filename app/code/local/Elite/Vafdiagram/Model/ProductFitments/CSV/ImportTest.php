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

class Elite_Vafdiagram_Model_ProductFitments_CSV_ImportTest extends Elite_Vafdiagram_Model_TestCase
{

    function doSetUp()
    {
	$this->switchSchema('make,model,year');
    }

    function testShouldImportFitmentsWithServiceCodeInsteadOfSku()
    {
	$product = $this->newProduct(1);
	$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
	$product->addServiceCode(123);

	$this->import('sku,make,model,year,service_code' . "\n" .
		',Honda,Civic,2000,123');

	$this->assertEquals(1, count($product->getFits()), 'should import fitments from service code');
    }

    function testShouldImportMultipleFitmentsWithServiceCodeInsteadOfSku()
    {
	$product = $this->newProduct(1);
	$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
	$product->addServiceCode(123);

	$this->import('sku,make,model,year,service_code' . "\n" .
		',Honda,Civic,2002,123' . "\n" .
		',Honda,Civic,2001,123');

	$this->assertEquals(2, count($product->getFits()), 'should import multiple fitments from service code');
    }

    function testShouldImportYearRange()
    {
	$product = $this->newProduct(1);
	$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
	$product->addServiceCode(123);

	$this->import('sku,make,model,year_start,year_end,service_code' . "\n" .
		',Honda,Civic,2001,2002,123' );

	$this->assertEquals(2, count($product->getFits()), 'should import year ranges');
    }

    function testShouldNotImportWrongFitmentsWhenServiceCodeDiffers()
    {
	$product = $this->newProduct(1);
	$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
	$product->addServiceCode(123);

	$this->import('sku,make,model,year,service_code' . "\n" .
		',Honda,Civic,2000,456');

	$this->assertEquals(0, count($product->getFits()), 'should not import wrong fitments when service code differs');
    }

    function testShouldAssociateServiceCodeToVehicle()
    {
	$product = $this->newProduct(1);
	$product = new Elite_Vafdiagram_Model_Catalog_Product($product);
	$product->addServiceCode(123);

	$this->import('sku,make,model,year,service_code' . "\n" .
		',Honda,Civic,2000,123');

	$vehicle = $this->vehicleFinder()->findOneByLevels(array('make' => 'Honda', 'model' => 'Civic', 'year' => '2000'));
	$vehicle = new Elite_Vafdiagram_Model_Vehicle($vehicle);
	$this->assertEquals('123', $vehicle->serviceCode(), 'should associate service code to vehicle');
    }


}