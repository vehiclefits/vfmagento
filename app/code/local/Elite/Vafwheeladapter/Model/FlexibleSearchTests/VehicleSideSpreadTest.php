<?php
class Elite_Vafwheeladapter_Model_FlexibleSearchTests_VehicleSideSpreadTest extends Elite_Vaf_TestCase
{
	function testShouldGetFromRequest()
    {
        $flexibleSearch = $this->flexibleWheeladapterSearch(array('vehicle_stud_spread'=>'5'));
        $this->assertEquals( 5, $flexibleSearch->vehicleSideStudSpread(), 'should get vehicle side stud spread from request' );
    }
    
    function testShouldStoreInSession()
    {
        $flexibleSearch = $this->flexibleWheeladapterSearch(array('vehicle_stud_spread'=>'5'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        $this->assertEquals( 5, $this->flexibleWheeladapterSearch()->vehicleSideStudSpread(), 'should store vehicle side stud spread in session' );
    }
    
    function testShouldClearFromSession()
    {
        $flexibleSearch = $this->flexibleWheeladapterSearch(array('vehicle_stud_spread'=>'5'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        
        $flexibleSearch = $this->flexibleWheeladapterSearch(array('vehicle_stud_spread'=>'0'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        
        $this->assertNull( $this->flexibleWheeladapterSearch()->vehicleSideStudSpread(), 'should clear vehicle side stud spread from session' );
    }
}
