<?php
class Elite_Vaftire_Model_FlexibleSearchTests_TypeTest extends Elite_Vaf_TestCase
{
	function testShouldGetFromRequest()
    {
        $flexibleSearch = $this->flexibleTireSearch(array('tire_type'=>2,'section_width'=>'205', 'aspect_ratio'=>'55', 'diameter'=>'16'));
        $this->assertEquals( 2, $flexibleSearch->tireType(), 'should get tire type from request' );
    }
    
    function testShouldStoreInSession()
    {
        $flexibleSearch = $this->flexibleTireSearch(array('tire_type'=>2,'section_width'=>'205', 'aspect_ratio'=>'55', 'diameter'=>'16'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        $this->assertEquals( 2, $this->flexibleTireSearch(array())->tireType(), 'should store tire type in session' );
    }
    
    function testShouldClearFromSession()
    {
        $flexibleSearch = $this->flexibleTireSearch(array('tire_type'=>2,'section_width'=>'205', 'aspect_ratio'=>'55', 'diameter'=>'16'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        
        $flexibleSearch = $this->flexibleTireSearch(array('tire_type'=>'','section_width'=>'0', 'aspect_ratio'=>'0', 'diameter'=>'0'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        
        $this->assertNull( $this->flexibleTireSearch()->tireType(), 'should clear tire type from session' );
    }
    
    function testShouldClearFromSession2()
    {
        $flexibleSearch = $this->flexibleTireSearch(array('tire_type'=>2,'section_width'=>'205', 'aspect_ratio'=>'55', 'diameter'=>'16'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        
        $flexibleSearch = $this->flexibleTireSearch(array('tire_type'=>'','section_width'=>'0', 'aspect_ratio'=>'0', 'diameter'=>'0'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        
        $this->assertNull( $flexibleSearch->tireType(), 'should clear tire type from session' );
    }
}