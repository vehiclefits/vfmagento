<?php
class Elite_Vaf_Model_Vehicle_FinderTests_RangeTest extends Elite_Vaf_Model_Vehicle_FinderTests_TestCase
{
    function testShouldFindRange()
    {
        $vehicle0 = $this->createMMY( 'Honda', 'Civic', '2000' );
        $vehicle1 = $this->createMMY( 'Honda', 'Civic', '2001' );
        $vehicle2 = $this->createMMY( 'Honda', 'Civic', '2002' );
        $vehicle3 = $this->createMMY( 'Honda', 'Civic', '2003' );
        
        $vehicles = $this->getFinder()->findByRange(array(
                'make'=>'Honda',
                'model'=>'Civic',
                'year_start'=>2000,
                'year_end'=>2003
        ));
        
        $this->assertEquals(4, count($vehicles));
    }
}