<?php
class Elite_Vaf_SnippetTest extends Elite_Vaf_TestCase
{
    const MAKE = 'Honda_Unique';
    const MODEL = 'Civic';
    const YEAR = '2002';
    
    /**
    *  Elite_Vaf_SnippetTest
    */
    function testSelection()
    {
        $vehicle = $this->createMMY( self::MAKE, self::MODEL, self::YEAR );
        $request = $this->getRequest( $vehicle->toValueArray() );
        $helper = new Elite_Vaf_Helper_Data();
        $helper->setRequest( $request );
        $vehicle = $helper->getFit();                                                              
        $this->assertMMYTitlesEquals( self::MAKE, self::MODEL, self::YEAR, $vehicle );
    }
    
    function testOrderFit()
    {
        $vehicle = $this->createMMY( self::MAKE, self::MODEL, self::YEAR );
        
        $vehicleFinder = new Elite_Vaf_Model_Vehicle_Finder( new Elite_Vaf_Model_Schema );
        $vehicle = $vehicleFinder->findByLeaf( $vehicle->getLevel('year')->getId() );
        $this->assertMMYTitlesEquals( self::MAKE, self::MODEL, self::YEAR, $vehicle );
    }
    
}