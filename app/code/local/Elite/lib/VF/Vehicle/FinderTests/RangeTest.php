<?php
class VF_Vehicle_FinderTests_RangeTest extends VF_Vehicle_FinderTests_TestCase
{
    function testShouldFindAllYearsINRange()
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
    
    function testShouldExcludeYearsOutsideRange()
    {
        $vehicle0 = $this->createMMY( 'Honda', 'Civic', '2000' );
        $vehicle1 = $this->createMMY( 'Honda', 'Civic', '2001' );
        $vehicle2 = $this->createMMY( 'Honda', 'Civic', '2002' );
        $vehicle3 = $this->createMMY( 'Honda', 'Civic', '2003' );
        
        $vehicles = $this->getFinder()->findByRange(array(
                'make'=>'Honda',
                'model'=>'Civic',
                'year_start'=>2000,
                'year_end'=>2001
        ));
        
        $this->assertEquals(2, count($vehicles));
    }
    
    function testShouldFindAllYearsINRange_Numeric()
    {
        $vehicle0 = $this->createMMY( 'Honda', 'Civic', '2000' );
        $vehicle1 = $this->createMMY( 'Honda', 'Civic', '2001' );
        $vehicle2 = $this->createMMY( 'Honda', 'Civic', '2002' );
        $vehicle3 = $this->createMMY( 'Honda', 'Civic', '2003' );
        
        $vehicles = $this->getFinder()->findByRangeIds(array(
                'make'=>$vehicle0->getValue('make'),
                'model'=>$vehicle0->getValue('model'),
                'year_start'=>$vehicle0->getValue('year'),
                'year_end'=>$vehicle3->getValue('year')
        ));
        
        $this->assertEquals(4, count($vehicles));
    }
    
    function testShouldFindAllYearsINRange_Numeric2()
    {
        $vehicle0 = $this->createMMY( 'Honda', 'Civic', '2000' );
        $vehicle1 = $this->createMMY( 'Honda', 'Civic', '2001' );
        
        $vehicles = $this->getFinder()->findByRangeIds(array(
                'make'=>$vehicle0->getValue('make'),
                'model'=>$vehicle0->getValue('model'),
                'year_start'=>$vehicle1->getValue('year'),
                'year_end'=>$vehicle0->getValue('year')
        ));
        
        $this->assertEquals(2, count($vehicles));
    }
}