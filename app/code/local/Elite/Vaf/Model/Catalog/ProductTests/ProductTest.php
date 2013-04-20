<?php
class Elite_Vaf_Model_Catalog_ProductTests_ProductTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{

    function testGetOrderBy()
    {
        $product = $this->getProduct();
        $this->assertEquals( '`make`,`model`,`year`', $product->getOrderBy() );
    }

}