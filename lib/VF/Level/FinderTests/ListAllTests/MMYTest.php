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
class VF_Level_FinderTests_ListAllTests_MMYTest extends Elite_Vaf_TestCase
{
    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testListAll_OnLevel()
    {
        $vehicle1 = $this->createMMY( 'A', 'A', '1' ); 
        $vehicle2 = $this->createMMY( 'A', 'B', '1' );
        $vehicle3 = $this->createMMY( 'A', 'C', '1' );
        
        $this->insertMappingMMY( $vehicle1 );
        $this->insertMappingMMY( $vehicle2 );
        $this->insertMappingMMY( $vehicle3 );
        
        $model = new VF_Level('model');
        $actual = $model->listAll();
        $this->assertEquals( 'A', $actual[0]->getTitle(), 'should sort items' );
        $this->assertEquals( 'B', $actual[1]->getTitle(), 'should sort items' );
        $this->assertEquals( 'C', $actual[2]->getTitle(), 'should sort items' );
    }
    
    function testListAll_OnFinder()
    {
        $vehicle1 = $this->createMMY( 'A', 'A', '1' ); 
        $vehicle2 = $this->createMMY( 'A', 'B', '1' );
        $vehicle3 = $this->createMMY( 'A', 'C', '1' );
        
        $this->insertMappingMMY( $vehicle1 );
        $this->insertMappingMMY( $vehicle2 );
        $this->insertMappingMMY( $vehicle3 );
        
        $actual = $this->levelFinder()->listAll('model');
        $this->assertEquals( 'A', $actual[0]->getTitle(), 'should sort items' );
        $this->assertEquals( 'B', $actual[1]->getTitle(), 'should sort items' );
        $this->assertEquals( 'C', $actual[2]->getTitle(), 'should sort items' );
    }
    
    function testListAllIsRepeatable()
    {
        $vehicle1 = $this->createMMY( 'A', 'A', '1' ); 
        $vehicle2 = $this->createMMY( 'A', 'B', '1' );
        $vehicle3 = $this->createMMY( 'A', 'C', '1' );
        
        $this->insertMappingMMY( $vehicle1 );
        $this->insertMappingMMY( $vehicle2 );
        $this->insertMappingMMY( $vehicle3 );
        
        $model = new VF_Level('model');
        $actual = $model->listAll();
        $actual = $model->listAll();
        $this->assertEquals( 'A', $actual[0]->getTitle(), 'should sort items' );
        $this->assertEquals( 'B', $actual[1]->getTitle(), 'should sort items' );
        $this->assertEquals( 'C', $actual[2]->getTitle(), 'should sort items' );
    }
    
    function testListAllWithParentId()
    {
        $vehicle1 = $this->createMMY( 'A', 'A', '1' ); 
        $vehicle2 = $this->createMMY( 'A', 'B', '1' );
        $vehicle3 = $this->createMMY( 'B', 'Z', 'Z' );
        
        $this->insertMappingMMY( $vehicle1 );
        $this->insertMappingMMY( $vehicle2 );
        $this->insertMappingMMY( $vehicle3 );
        
        $model = new VF_Level('model');
        $actual = $model->listAll($vehicle1->getLevel('make')->getId());
        $this->assertEquals( 'A', $actual[0]->getTitle(), 'should sort items' );
        $this->assertEquals( 'B', $actual[1]->getTitle(), 'should sort items' );
    }  
    
}
