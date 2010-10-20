<?php
class Elite_Vaftire_Model_FlexibleSearchTests_FilterBySizeTest extends Elite_Vaf_TestCase
{
    function testTireSearch()
    {
        $tireSize = new Elite_Vaftire_Model_TireSize(205,55,16);
        
        $product = $this->newTireProduct();
        $product->setId(1);
        $product->setTireSize($tireSize);
        
        $flexibleSearch = $this->flexibleTireSearch(array('section_width'=>'205', 'aspect_ratio'=>'55', 'diameter'=>'16'));
        $this->assertEquals( array(1), $flexibleSearch->doGetProductIds(), 'when user is searching on a tire size should find matching tires' );
	}
	
	function testInvalidCombination()
    {
        $tireSize = new Elite_Vaftire_Model_TireSize(205,55,16);
        
        $product = $this->newTireProduct();
        $product->setId(1);
        $product->setTireSize($tireSize);
        
        $flexibleSearch = $this->flexibleTireSearch(array('section_width'=>'206', 'aspect_ratio'=>'56', 'diameter'=>'17'));
        $this->assertEquals( array(0), $flexibleSearch->doGetProductIds(), 'if user searches on non existant combination there should be no products array(0) is to activate filter' );
	}
    
}