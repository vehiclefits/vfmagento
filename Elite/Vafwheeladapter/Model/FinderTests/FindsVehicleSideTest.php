<?php
class Elite_Vafwheeladapter_Model_FinderTests_FindsVehicleSideTest extends Elite_Vaf_TestCase
{
	function testShouldFindLugCount()
    {
    	$product = $this->newWheeladapterProduct(1);
        $product->addVehicleSideBoltPattern($this->boltPattern('4x114.3'));
        $product->addVehicleSideBoltPattern($this->boltPattern('5x114.3'));
        
        $this->assertEquals( array(4=>4, 5=>5), $this->wheelAdapterFinder()->listVehicleSideLugCounts(), 'should list lug counts' );
	}
	
	function testShouldFindSideSpread()
    {
    	$product = $this->newWheeladapterProduct(1);
        $product->addVehicleSideBoltPattern($this->boltPattern('4x114.3'));
        $product->addVehicleSideBoltPattern($this->boltPattern('4x117.3'));
        
        $this->assertEquals( array('114.3'=>114.3, '117.3'=>117.3), $this->wheelAdapterFinder()->listVehicleSideSpread(), 'should list lug counts' );
	}
	
}