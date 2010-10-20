<?php
class Elite_Vafwheeladapter_Model_FlexibleSearchTests_FilterTests_WheelSideTest extends Elite_Vaf_TestCase
{
	function testShouldFilterOnWheelSide()
    {
        $product = $this->newWheelAdapterProduct();
        $product->setId(1);
        
        $product->setWheelSideBoltPattern($this->boltPattern('4x114.3'));
        
        $params = array('wheel_lug_count'=>'4', 'wheel_stud_spread'=>'114.3');
        $this->setRequestParams($params);
        
        $flexibleSearch = $this->flexibleWheeladapterSearch($params);
        $this->assertEquals( array(1), $flexibleSearch->doGetProductIds(), 'should filter on wheel side' );
    }
    
    function testShouldFilterOnVehicleSelection()
    {
		$vehicle = $this->createMMY();
		
		$product = $this->newWheelAdapterProduct();
        $product->setId(1);
        $product->addVafFit( $vehicle->toValueArray() );
        
        $product->setWheelSideBoltPattern($this->boltPattern('4x114.3'));
        
        $params = $vehicle->toValueArray() + array('wheel_lug_count'=>'4', 'wheel_stud_spread'=>'114.3');
        $this->setRequestParams($params);
        
        $flexibleSearch = $this->flexibleWheeladapterSearch($params);
        $this->assertEquals( array(1), $flexibleSearch->doGetProductIds(), 'should filter on wheel side' );
    }
    
    function testShouldOmitDifferentVehicleSelection()
    {
		$vehicle1 = $this->createMMY('Honda','Civic','2000');
		$vehicle2 = $this->createMMY('Honda','Civic','2001');
		
		$product = $this->newWheelAdapterProduct();
        $product->setId(1);
        $product->addVafFit( $vehicle1->toValueArray() );
        
        $product->setWheelSideBoltPattern($this->boltPattern('4x114.3'));
        
        $params = $vehicle2->toValueArray() + array('wheel_lug_count'=>'4', 'wheel_stud_spread'=>'114.3');
        $this->setRequestParams($params);
        
        $flexibleSearch = $this->flexibleWheeladapterSearch($params);
        $this->assertEquals( array(0), $flexibleSearch->doGetProductIds(), 'should omit different vehicle selections (even if wheel side bolt matches)' );
    }
        
    function testClearingVehicleSelection()
    {
		return $this->markTestIncomplete();
		$vehicle = $this->createMMY();
		
		$product = $this->newWheelAdapterProduct();
        $product->setId(1);
        $product->addVafFit( $vehicle->toValueArray() );
        
        $product->setWheelSideBoltPattern($this->boltPattern('4x114.3'));
        
        $params = $vehicle->toValueArray() + array('wheel_lug_count'=>'4', 'wheel_stud_spread'=>'114.3');
        $this->setRequestParams($params);
        
        $flexibleSearch = $this->flexibleWheeladapterSearch($params);
        $this->assertEquals( array(1), $flexibleSearch->doGetProductIds() );
        
        $params = array('make'=>0,'model'=>0,'year'=>0) + array('wheel_lug_count'=>'4', 'wheel_stud_spread'=>'114.3');
        $this->setRequestParams($params);
        
//        debugbreak();
        $flexibleSearch = $this->flexibleWheeladapterSearch($params);
        $this->assertEquals( array(1), $flexibleSearch->doGetProductIds() );
    }
    
}