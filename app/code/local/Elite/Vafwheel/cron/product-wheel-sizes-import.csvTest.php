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
class product_wheel_sizes_import_csvTest extends VF_TestCase
{
    function testTest()
    {
	return $this->markTestIncomplete();
//	$data = '"sku","lug_count","bolt_distance"';
//	$data .= '"sku","4","144.3"';
//        $file = 'product-wheel-sizes-import.csv';
//	$file = dirname(__FILE__).'/'.$file;
//        file_put_contents( $file, $data );
//
//        $this->insertProduct('sku');
//
//	exec('php ' . dirname(__FILE__) . '/product-wheel-sizes-import.csv.php');
//
//	$product = $this->getProductForSku('sku');
//        $product = new VF_Wheel_Catalog_Product($product);
//        $boltPatterns = $product->getBoltPatterns();
//
//        $this->assertEquals( 4, $boltPatterns[0]->getLugCount(), 'should set lug_count' );
//        $this->assertEquals( 144.3, $boltPatterns[0]->getDistance(), 'should set bolt distance' );
    }
}