<?php
class Elite_Vafwheeladapter_Model_Catalog_ProductTest extends Elite_Vaf_TestCase
{ 
    function testWhenNoVehicleSide()
    {
        $product = $this->newWheeladapterProduct();
        $product->setId(1);
        $this->assertEquals( array(), $product->getVehicleSideBoltPatterns(), 'when product has no vehicle side bolt patterns should return emtpy array' );
    }
    
    function testWhenNoWheelSide()
    {
        $product = $this->newWheeladapterProduct();
        $product->setId(1);
        $this->assertFalse( $product->getWheelSideBoltPattern(), 'when product has no wheel side bolt pattern should return false' );
    }
    
    function testShouldHaveSingleVehicleSide()
    {
        $product = $this->newWheeladapterProduct();
        $product->setId(1);
        $product->addVehicleSideBoltPattern( $this->boltPattern('4x114.3') );
        
        $product = $this->newWheeladapterProduct();
        $product->setId(1);
        
        $boltPatterns = $product->getVehicleSideBoltPatterns();
        $this->assertEquals( 4, $boltPatterns[0]->getLugCount(), 'should be able to have single vehicle side bolt patterns' );
        $this->assertEquals( 114.3, $boltPatterns[0]->getDistance(), 'should be able to have single vehicle side bolt patterns' );
    }
    
    function testShouldHaveMultipleVehicleSide()
    {
        $product = $this->newWheeladapterProduct();
        $product->setId(1);
        $product->addVehicleSideBoltPattern( $this->boltPattern('4x114.3') );
        $product->addVehicleSideBoltPattern( $this->boltPattern('5x114.3') );
        
        $product = $this->newWheeladapterProduct();
        $product->setId(1);
        
        $boltPatterns = $product->getVehicleSideBoltPatterns();
        $this->assertEquals( 2, count($boltPatterns), 'should be able to have multiple vehicle side bolt patterns' );
    }
    
    function testShouldHaveOneWheelSide()
    {
		$product = $this->newWheeladapterProduct();
        $product->setId(1);
        
        $product->setWheelSideBoltPattern( $this->boltPattern('4x114.3') );
        
        $product = $this->newWheeladapterProduct();
        $product->setId(1);
        
        $boltPattern = $product->getWheelSideBoltPattern();
        $this->assertEquals( 4, $boltPattern->getLugCount(), 'should be able to have single wheel side bolt patterns' );
        $this->assertEquals( 114.3, $boltPattern->getDistance(), 'should be able to have single wheel side bolt patterns' );
    }
}