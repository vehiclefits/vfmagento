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
class VF_Level_FinderTests_FindByTitleInUseTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testShouldNotIncludeOptionsNotInUse()
    {
        $vehicle1 = $this->createMMY( 'A', 'A', '1' );
        $vehicle2 = $this->createMMY( 'A', 'B', '1' );
        $vehicle3 = $this->createMMY( 'A', 'C', '1' );

        $this->insertMappingMMY( $vehicle1 );
        $this->insertMappingMMY( $vehicle2 );

        $model = new VF_Level('model');
        $actual = $model->listInUseByTitle();
        $this->assertEquals( 'A', $actual[0]->getTitle() );
        $this->assertEquals( 'B', $actual[1]->getTitle() );
        $this->assertFalse( isset($actual[2]) );
    }
    
    function testWithParentModel()
    {
        $vehicle1 = $this->createMMY( 'Acura', 'Integra', '2002' ); 
        $vehicle2 = $this->createMMY( 'Honda', 'Accord', '2002' ); 
        $vehicle3 = $this->createMMY( 'Honda', 'Civic', '2002' ); 
        
        $this->insertMappingMMY( $vehicle1 );
        $this->insertMappingMMY( $vehicle2 );
        $this->insertMappingMMY( $vehicle3 );
        
        $model = new VF_Level('model');
        $actual = $model->listInUseByTitle( array( 'make' => $vehicle2->getLevel('make')->getTitle() ) );
        $this->assertEquals( 2, count($actual ) );
        $this->assertEquals( $vehicle2->getLevel('model')->getId(), $actual[0]->getId() );
        $this->assertEquals( $vehicle3->getLevel('model')->getId(), $actual[1]->getId() );
    } 
    
    function testWithParentYear()
    {
        $vehicle1 = $this->createMMY( 'Acura', 'Integra', '2002' ); 
        $vehicle2 = $this->createMMY( 'Honda', 'Accord', '2002' ); 
        $vehicle3 = $this->createMMY( 'Honda', 'Civic', '2002' ); 
        
        $this->insertMappingMMY( $vehicle1 );
        $this->insertMappingMMY( $vehicle2 );
        $this->insertMappingMMY( $vehicle3 );
        
        $year = new VF_Level('year');
        $actual = $year->listInUseByTitle( array( 'make' => $vehicle2->getLevel('make')->getTitle(), 'model'=> $vehicle2->getLevel('model')->getTitle()) );
        $this->assertEquals( 1, count($actual ) );
        $this->assertEquals( $vehicle2->getLevel('year')->getId(), $actual[0]->getId() );

    } 
}