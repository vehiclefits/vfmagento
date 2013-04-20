<?php
class Elite_Vafwheeladapter_Model_FlexibleSearchTests_WheelSideSpreadTest extends Elite_Vaf_TestCase
{
	function testShouldGetFromRequest()
    {
        $flexibleSearch = $this->flexibleWheeladapterSearch(array('wheel_stud_spread'=>114.3));
        $this->assertEquals( 114.3, $flexibleSearch->wheelSideStudSpread(), 'should get wheel side stud spread from request' );
    }
    
    function testShouldStoreInSession()
    {
        $flexibleSearch = $this->flexibleWheeladapterSearch(array('wheel_stud_spread'=>'114.3'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        $this->assertEquals( 114.3, $this->flexibleWheeladapterSearch()->wheelSideStudSpread(), 'should store wheel side stud spread in session' );
    }
    
    function testShouldClearFromSession()
    {
        $flexibleSearch = $this->flexibleWheeladapterSearch(array('wheel_stud_spread'=>'114.3'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        
        $flexibleSearch = $this->flexibleWheeladapterSearch(array('wheel_stud_spread'=>'0'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        
        $this->assertNull( $this->flexibleWheeladapterSearch()->wheelSideStudSpread(), 'should clear wheel side stud spread from session' );
    }
}