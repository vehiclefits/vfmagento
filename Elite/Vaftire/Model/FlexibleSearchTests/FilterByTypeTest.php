<?php
class Elite_Vaftire_Model_FlexibleSearchTests_FilterByTypeTest extends Elite_Vaf_TestCase
{
	function testFilterByType()
    {
        $tireSize = new Elite_Vaftire_Model_TireSize(205,55,16);
        
        $product = $this->newTireProduct();
        $product->setId(1);
        $product->setTireSize($tireSize);
        $product->setTireType(Elite_Vaftire_Model_Catalog_Product::SUMMER_ALL);
        
        $flexibleSearch = $this->flexibleTireSearch(array('section_width'=>'205', 'aspect_ratio'=>'55', 'diameter'=>'16', 'tire_type'=>Elite_Vaftire_Model_Catalog_Product::SUMMER_ALL));
        $this->assertEquals( array(1), $flexibleSearch->doGetProductIds(), 'should filter by tire type' );
	}
	
	function testOmitsDifferentType()
	{
		$tireSize = new Elite_Vaftire_Model_TireSize(205,55,16);
        
        $product = $this->newTireProduct();
        $product->setId(1);
        $product->setTireSize($tireSize);
        $product->setTireType(Elite_Vaftire_Model_Catalog_Product::SUMMER_ALL);
        
        $flexibleSearch = $this->flexibleTireSearch(array('section_width'=>'205', 'aspect_ratio'=>'55', 'diameter'=>'16', 'tire_type'=>Elite_Vaftire_Model_Catalog_Product::WINTER));
        $this->assertEquals( array(0), $flexibleSearch->doGetProductIds(), 'should exclude different tire type' );
	}
    	
	function testAllTypes()
	{
		$tireSize = new Elite_Vaftire_Model_TireSize(205,55,16);
        
        $product = $this->newTireProduct();
        $product->setId(1);
        $product->setTireSize($tireSize);
        $product->setTireType(Elite_Vaftire_Model_Catalog_Product::SUMMER_ALL);
        
        $flexibleSearch = $this->flexibleTireSearch(array('section_width'=>'205', 'aspect_ratio'=>'55', 'diameter'=>'16', 'tire_type'=>0));
        $this->assertEquals( array(1), $flexibleSearch->doGetProductIds(), 'should show all types' );
	}
    
}