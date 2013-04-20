<?php
class Elite_Vafwheel_Model_FlexibleSearchTests_StudSpreadTest extends Elite_Vaf_TestCase
{
	function testShouldGetFromRequest()
    {
        $flexibleSearch = $this->flexibleWheelSearch(array('stud_spread'=>'114.3'));
        $this->assertEquals( 114.3, $flexibleSearch->studSpread(), 'should get stud spread from request' );
    }
    
    function testShouldStoreInSession()
    {
        $flexibleSearch = $this->flexibleWheelSearch(array('stud_spread'=>'114.3'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        $this->assertEquals( 114.3, $this->flexibleWheelSearch()->studSpread(), 'should store stud spread in session' );
    }
    
    function testShouldClearFromSession()
    {
        $flexibleSearch = $this->flexibleWheelSearch(array('stud_spread'=>'5'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        
        $flexibleSearch = $this->flexibleWheelSearch(array('stud_spread'=>'0'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        
        $this->assertEquals( 0, $this->flexibleWheelSearch()->studSpread(), 'should clear stud spread from session' );
    }
}