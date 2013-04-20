<?php
class Elite_Vaftire_Model_FinderTest extends Elite_Vaf_TestCase
{
    function testFindsProductBySize()
    {
        $tireSize = new Elite_Vaftire_Model_TireSize(205,55,16);
        $this->newTireProduct(1,$tireSize);
        $this->assertEquals( array(1), $this->tireFinder()->productIds($tireSize), 'should find products with this tire size' );
    }
    
    function testFindsProductBySizeAndType()
    {
        $tireSize = new Elite_Vaftire_Model_TireSize(205,55,16);
        $product = $this->newTireProduct(1,$tireSize,Elite_Vaftire_Model_Catalog_Product::SUMMER_ALL);
        $actual = $this->tireFinder()->productIds($tireSize,Elite_Vaftire_Model_Catalog_Product::SUMMER_ALL);
        $this->assertEquals( array(1), $actual, 'should find products with this tire size & tire type' );
    }
        
    function testOmitsProductOfDifferentType()
    {
        $tireSize = new Elite_Vaftire_Model_TireSize(205,55,16);
        $product = $this->newTireProduct(1,$tireSize,Elite_Vaftire_Model_Catalog_Product::SUMMER_ALL);
        $actual = $this->tireFinder()->productIds($tireSize,Elite_Vaftire_Model_Catalog_Product::WINTER);
        $this->assertEquals( array(), $actual, 'should omit products of different tire type' );
    }
    
    function testOmitsProductOfDifferentSize()
    {
		$tireSize1 = new Elite_Vaftire_Model_TireSize(205,55,16);
		$tireSize2 = new Elite_Vaftire_Model_TireSize(206,56,17);
        $product = $this->newTireProduct(1,$tireSize1);
        $this->assertEquals( array(), $this->tireFinder()->productIds($tireSize2), 'should omit products of different tire size' );
    }

}