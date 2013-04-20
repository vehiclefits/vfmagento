<?php
class Elite_Vafwheeladapter_Model_FlexibleSearchTests_FilterTests_VehicleSideTest extends Elite_Vaf_TestCase
{
	function testShouldFilterOnVehicleSide()
    {
        $product = $this->newWheelAdapterProduct();
        $product->setId(1);
        
        $product->addVehicleSideBoltPattern($this->boltPattern('4x114.3'));
        
        $params = array('vehicle_lug_count'=>'4', 'vehicle_stud_spread'=>'114.3');
        $this->setRequestParams($params);
        
        $flexibleSearch = $this->flexibleWheeladapterSearch($params);
        $this->assertEquals( array(1), $flexibleSearch->doGetProductIds(), 'should filter on wheel side' );
    }
    
}