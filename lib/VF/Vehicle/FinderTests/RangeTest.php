<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
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