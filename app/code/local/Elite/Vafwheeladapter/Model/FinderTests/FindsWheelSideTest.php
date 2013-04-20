<?php
class Elite_Vafwheeladapter_Model_FinderTests_FindsWheelSideTest extends Elite_Vaf_TestCase
{
    function testFindsLugCount()
    {
    	$product = $this->newWheeladapterProduct(1);
        $product->setWheelSideBoltPattern($this->boltPattern('4x114.3'));
        
        $product = $this->newWheeladapterProduct(2);
        $product->setWheelSideBoltPattern($this->boltPattern('5x114.3'));
        
        $this->assertEquals( array(4=>4, 5=>5), $this->wheelAdapterFinder()->listWheelSideLugCounts(), 'should list possible wheel side lug counts' );
	}
	
	function testFindsSpread()
    {
    	$product = $this->newWheeladapterProduct();
        $product->setId(1);
        $product->setWheelSideBoltPattern($this->boltPattern('4x114.3'));
        
        $product = $this->newWheeladapterProduct();
        $product->setId(2);
        $product->setWheelSideBoltPattern($this->boltPattern('4x117.3'));
        
        $this->assertEquals( array('114.3'=>114.3, '117.3'=>117.3), $this->wheelAdapterFinder()->listWheelSideSpread(), 'should list possible wheel side lug counts' );
	}
	
}