<?php
class product_wheel_sizes_import_csvTest extends Elite_Vaf_TestCase
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
//        $product = new Elite_Vafwheel_Model_Catalog_Product($product);
//        $boltPatterns = $product->getBoltPatterns();
//
//        $this->assertEquals( 4, $boltPatterns[0]->getLugCount(), 'should set lug_count' );
//        $this->assertEquals( 144.3, $boltPatterns[0]->getDistance(), 'should set bolt distance' );
    }
}