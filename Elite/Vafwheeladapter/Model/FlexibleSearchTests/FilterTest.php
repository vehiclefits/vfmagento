<?php
class Elite_Vafwheeladapter_Model_FlexibleSearchTests_FilterTest extends Elite_Vaf_TestCase
{
    
    function testNoSelection()
    {
		 $flexibleSearch = $this->flexibleWheeladapterSearch(array());
		 $this->assertEquals( array(), $flexibleSearch->doGetProductIds(), 'should have no selection' );
    }
    
    function testShouldFilterOnWheelSideAndVehicleSide()
    {
        $product = $this->newWheelAdapterProduct();
        $product->setId(1);
        
        $product->addVehicleSideBoltPattern($this->boltPattern('5x117.3'));
        $product->setWheelSideBoltPattern($this->boltPattern('4x114.3'));
        
        $params = array('wheel_lug_count'=>'4', 'wheel_stud_spread'=>'114.3', 'vehicle_lug_count' => '5', 'vehicle_stud_spread' => '117.3');
        $this->setRequestParams($params);
        
        $flexibleSearch = $this->flexibleWheeladapterSearch($params);
        $this->assertEquals( array(1), $flexibleSearch->doGetProductIds(), 'should filter on wheel side & vehicle side' );
    }
    
    function testOmitsDifferentVehicleSide()
    {
        $product = $this->newWheelAdapterProduct();
        $product->setId(1);
        
        $product->addVehicleSideBoltPattern($this->boltPattern('6x117.3'));
        $product->setWheelSideBoltPattern($this->boltPattern('4x114.3'));
        
        $params = array('wheel_lug_count'=>'4', 'wheel_stud_spread'=>'114.3', 'vehicle_lug_count' => '5', 'vehicle_stud_spread' => '117.3');
        $this->setRequestParams($params);
        
        $flexibleSearch = $this->flexibleWheeladapterSearch($params);
        $this->assertEquals( array(0), $flexibleSearch->doGetProductIds(), 'omits different vehicle side' );
    }
      
    function testOmitsDifferentWheelSide()
    {
        $product = $this->newWheelAdapterProduct();
        $product->setId(1);
        
        $product->addVehicleSideBoltPattern($this->boltPattern('5x117.3'));
        $product->setWheelSideBoltPattern($this->boltPattern('5x114.3'));
        
        $params = array('wheel_lug_count'=>'4', 'wheel_stud_spread'=>'114.3', 'vehicle_lug_count' => '5', 'vehicle_stud_spread' => '117.3');
        $this->setRequestParams($params);
        
        $flexibleSearch = $this->flexibleWheeladapterSearch($params);
        $this->assertEquals( array(0), $flexibleSearch->doGetProductIds(), 'omits different wheel side' );
    }
    
}