<?php
class Elite_Vafwheeladapter_Model_FinderTests_FindsProductsTest extends Elite_Vaf_TestCase
{
	function testFindsMatchingProductForVehicleSide()
    {
        $vehicleBolt = $this->boltPattern('4x114.3');
        $product = $this->newWheelAdapterProduct(1);
        $product->addVehicleSideBoltPattern($vehicleBolt);
        $this->assertEquals( array(1), $this->wheelAdapterFinder()->getProductIds(null,$vehicleBolt), 'should find products via the vehicle side bolt pattern' );
    }
    
    function testFindsMatchingProductForWheelSide()
    {
        $wheelBolt = $this->boltPattern('4x114.3');
        $product = $this->newWheelAdapterProduct(1);
        $product->setWheelSideBoltPattern($wheelBolt);
        $this->assertEquals( array(1), $this->wheelAdapterFinder()->getProductIds($wheelBolt,null), 'should find products via the wheel side bolt pattern' );
    }
    
    function testFindsMatchingProductConstrainedByBothSides()
    {
		$vehicleBolt = $this->boltPattern('5x117.3');
		$wheelBolt = $this->boltPattern('4x114.3');
        
        $product = $this->newWheelAdapterProduct(1);
        $product->addVehicleSideBoltPattern($vehicleBolt);
        $product->setWheelSideBoltPattern($wheelBolt);
        
        $this->assertEquals( array(1), $this->wheelAdapterFinder()->getProductIds($wheelBolt,$vehicleBolt), 'should find products via the wheel side bolt pattern' );
    }
    
    function testFindsExcludesProductNotMatchingVehicleSide()
    {
		$vehicleBolt = $this->boltPattern('5x117.3');
		$wheelBolt = $this->boltPattern('4x114.3');
        
        $product = $this->newWheelAdapterProduct(1);
        $product->addVehicleSideBoltPattern($vehicleBolt);
        $product->setWheelSideBoltPattern($wheelBolt);
        
        $vehicleBolt = $this->boltPattern('4x114.3');
        $this->assertEquals( array(), $this->wheelAdapterFinder()->getProductIds($wheelBolt,$vehicleBolt), 'should exclude products not matching vehicle side' );
    }
}