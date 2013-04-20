<?php
class Elite_Vafwheeladapter_Model_FlexibleSearchTests_VehicleSideLugCountTest extends Elite_Vaf_TestCase
{
	function testShouldGetFromRequest()
    {
        $flexibleSearch = $this->flexibleWheeladapterSearch(array('vehicle_lug_count'=>'5'));
        $this->assertEquals( 5, $flexibleSearch->vehicleSideLugCount(), 'should get vehicle side lug count from request' );
    }
    
    function testShouldStoreInSession()
    {
        $flexibleSearch = $this->flexibleWheeladapterSearch(array('vehicle_lug_count'=>'5'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        $this->assertEquals( 5, $this->flexibleWheeladapterSearch()->vehicleSideLugCount(), 'should store vehicle side lug count in session' );
    }
    
    function testShouldClearFromSession()
    {
        $flexibleSearch = $this->flexibleWheeladapterSearch(array('vehicle_lug_count'=>'5'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        
        $flexibleSearch = $this->flexibleWheeladapterSearch(array('vehicle_lug_count'=>'0'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        
        $this->assertNull( $this->flexibleWheeladapterSearch()->vehicleSideLugCount(), 'should clear vehicle side lug count from session' );
    }
}
