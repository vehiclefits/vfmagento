<?php
class Elite_Vafwheeladapter_Model_FlexibleSearchTests_WheelSideLugCountTest extends Elite_Vaf_TestCase
{
	function testShouldGetFromRequest()
    {
        $flexibleSearch = $this->flexibleWheeladapterSearch(array('wheel_lug_count'=>'5'));
        $this->assertEquals( 5, $flexibleSearch->wheelSideLugCount(), 'should get wheel side lug count from request' );
    }
    
    function testShouldStoreInSession()
    {
        $flexibleSearch = $this->flexibleWheeladapterSearch(array('wheel_lug_count'=>'5'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        $this->assertEquals( 5, $this->flexibleWheeladapterSearch()->wheelSideLugCount(), 'should store wheel side lug count in session' );
    }
    
    function testShouldClearFromSession()
    {
        $flexibleSearch = $this->flexibleWheeladapterSearch(array('wheel_lug_count'=>'5'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        
        $flexibleSearch = $this->flexibleWheeladapterSearch(array('wheel_lug_count'=>'0'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        
        $this->assertNull( $this->flexibleWheeladapterSearch()->wheelSideLugCount(), 'should clear wheel side lug count from session' );
    }
}