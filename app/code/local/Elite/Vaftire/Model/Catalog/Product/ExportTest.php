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
class Elite_Vaftire_Model_Catalog_Product_ExportTest extends Elite_Vaf_TestCase
{
	function testExportHeaders()
	{
	    $tireSize = new Elite_Vaftire_Model_TireSize(205, 55, 16);

	    $id = $this->insertProduct( 'sku123' );

	    $product = $this->newTireProduct();
	    $product->setId($id);
	    $product->setTireSize($tireSize);

	    $stream = fopen("php://temp", 'w');
	    $export = new Elite_Vaftire_Model_Catalog_Product_ExportTestSub;
	    $export->export($stream);

	    rewind($stream);

	    $data = stream_get_contents($stream);

	    $expected = '"sku","section_width","aspect_ratio","diameter"
"sku123","205","55","16"
';

	    $this->assertEquals( $expected, $data );
	}
}

class Elite_Vaftire_Model_Catalog_Product_ExportTestSub extends Elite_Vaftire_Model_Catalog_Product_Export
{
    function getProductTable()
    {
	return 'test_catalog_product_entity';
    }
}