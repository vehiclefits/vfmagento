<?php
class Elite_Vafwheel_Model_FlexibleSearchTests_WheelSearchTest extends Elite_Vaf_TestCase
{
    function testShouldFindMatchingWheels()
    {
        $product = $this->newWheelProduct(1);
        $product->addBoltPattern($this->boltPattern('4x114.3'));
        $this->setRequestParams(array('lug_count'=>'4', 'stud_spread'=>'114.3'));
        $this->assertEquals( array(1), $this->flexibleWheelSearch()->doGetProductIds(), 'when user is searching on a bolt pattern should find matching wheels' );
    }
    
    function testNonExistantCombination()
    {
        $product = $this->newWheelProduct(1);
        $product->addBoltPattern($this->boltPattern('4x114.3'));
        $this->setRequestParams(array('lug_count'=>'5', 'stud_spread'=>'114.3'));
        $this->assertEquals( array(0), $this->flexibleWheelSearch()->doGetProductIds(), 'if user searches on non existant combination there should be no products array(0) is to activate filter' );
    }
}