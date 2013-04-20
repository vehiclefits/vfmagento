<?php
class Elite_Vafwheeladapter_Model_FinderTests_SortsWheelSideTest extends Elite_Vaf_TestCase
{
	function testShouldSortLugCount()
    {
    	$product = $this->newWheeladapterProduct(1);
        $product->setWheelSideBoltPattern($this->boltPattern('5x114.3'));
        
        $product = $this->newWheeladapterProduct(2);
        $product->setWheelSideBoltPattern($this->boltPattern('4x114.2'));
        
        $actual = array_values($this->wheelAdapterFinder()->listWheelSideLugCounts());
        $this->assertEquals( '4', $actual[0], 'should sort lug counts' );
        $this->assertEquals( '5', $actual[1], 'should sort lug counts' );
	}
	
	function testShouldSortStudSpread()
    {
    	$product = $this->newWheeladapterProduct(1);
        $product->setWheelSideBoltPattern($this->boltPattern('5x114.3'));
        
        $product = $this->newWheeladapterProduct(2);
        $product->setWheelSideBoltPattern($this->boltPattern('4x114.2'));
        
        $actual = array_values($this->wheelAdapterFinder()->listWheelSideSpread());
        $this->assertEquals( '114.2', $actual[0], 'should sort stud spread' );
        $this->assertEquals( '114.3', $actual[1], 'should sort stud spread' );
	}
}