<?php
class Elite_Vafwheel_Model_FlexibleSearchTests_LugCountTest extends Elite_Vaf_TestCase
{
	function testShouldGetFromRequest()
    {
        $flexibleSearch = $this->flexibleWheelSearch(array('lug_count'=>'5'));
        $this->assertEquals( 5, $flexibleSearch->lugCount(), 'should get lug count from request' );
    }
    
    function testShouldStoreInSession()
    {
        $flexibleSearch = $this->flexibleWheelSearch(array('lug_count'=>'5'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        $this->assertEquals( 5, $this->flexibleWheelSearch()->lugCount(), 'should store lug count in session' );
    }
    
    function testShouldClearFromSession()
    {
        $flexibleSearch = $this->flexibleWheelSearch(array('lug_count'=>'5'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        
        $flexibleSearch = $this->flexibleWheelSearch(array('lug_count'=>'0'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        
        $this->assertEquals( 0, $this->flexibleWheelSearch()->lugCount(), 'should clear lug count from session' );
    }
}