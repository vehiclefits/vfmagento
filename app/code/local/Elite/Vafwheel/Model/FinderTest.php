<?php
class Elite_Vafwheel_Model_FinderTest extends Elite_Vaf_TestCase
{
    function testFindsPossibleLugCount()
    {
        $product = $this->newWheelProduct(1);
        $product->addBoltPattern($this->boltPattern('4x114.3'));
        $product->addBoltPattern($this->boltPattern('5x114.3'));
        
        $this->assertEquals( array(4=>4, 5=>5), $this->wheelFinder()->listLugCounts(), 'should list possible lug counts' );
    }
    
    function testFindsPossibleSpread()
    {
        $product = $this->newWheelProduct(1);
        $product->addBoltPattern($this->boltPattern('4x114.3'));
        $product->addBoltPattern($this->boltPattern('5x114.3'));
        
        $this->assertEquals( array('114.3'=>114.3), $this->wheelFinder()->listSpread(), 'should list possible spread(s)' );
    }
    
    function testFindsMatchingProduct()
    {
        $bolt = Elite_Vafwheel_Model_BoltPattern::create('4x114.3');
        
        $product = $this->newWheelProduct(1);
        $product->addBoltPattern($bolt);
        
        $this->assertEquals( array(1), $this->wheelFinder()->getProductIds($bolt), 'should find products with this bolt pattern' );
    }
    
    function wheelFinder()
    {
		return new Elite_Vafwheel_Model_Finder;
    }
}