<?php
class VF_SearchLevelTest extends Elite_Vaf_TestCase
{
    const MAKE = 'Honda';
    const MODEL = 'Civic';
    const YEAR = '2002';
    
    function testMakeSelected()
    {
        $vehicle = $this->createMMY( self::MAKE, self::MODEL, self::YEAR );
        
        $searchlevel = new VF_SearchLevel_TestSub();
        $searchlevel->display( new Elite_Vaf_Block_Search, 'make' );
        
        Elite_Vaf_Helper_Data::getInstance()->getRequest()->setParam('make', $vehicle->getLevel('make')->getId() );
        
        $entity = $this->levelFinder()->find('make',$vehicle->getValue('make'));
        $this->assertTrue( $searchlevel->getSelected($entity) );
    }
    
    // 0000468: When making an incomplete selection "change" button on my garage produces error
    function testModelSelected()
    {
        $vehicle = $this->createMMY( self::MAKE, self::MODEL, self::YEAR );
        
        $searchlevel = new VF_SearchLevel_TestSub();
        $searchlevel->display( new Elite_Vaf_Block_Search, 'year' );
        
        Elite_Vaf_Helper_Data::getInstance()->getRequest()->setParam('make', $vehicle->getLevel('make')->getId() );
        Elite_Vaf_Helper_Data::getInstance()->getRequest()->setParam('model', $vehicle->getLevel('model')->getId() );
        
        $entity = $this->levelFinder()->find('year',$vehicle->getValue('year'));
        $this->assertFalse( $searchlevel->getSelected($entity) );
    }
    
}

class VF_SearchLevel_TestSub extends VF_SearchLevel
{
    function __($arg)
    {
        return $arg;
    }
}