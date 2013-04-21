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
class Elite_Vaf_Block_SearchTests_Search_ListEntitiesYMMTest extends Elite_Vaf_Block_SearchTests_TestCase
{
    const MODEL2 = 'model2';
    
    function doSetUp()
    {
		$this->switchSchema('year,make,model');
    }
    
    function testListYear()
    {
        $block = $this->getBlock();
        
        $vehicle = $this->createYMM();
        
        $this->insertMappingYMM( $vehicle->getLevel('year')->getId(), $vehicle->getLevel('make')->getId(), $vehicle->getLevel('model')->getId() );
        $actual = $block->listEntities( 'year', '' );
        $this->assertEquals( 1, count($actual) );
        $this->assertEquals( $vehicle->getLevel('year')->getId(), $actual[0]->getId(), 'if listing years in leaf first mode it returns the years in use' );
    }
    
    function testListMake()
    {
        $block = $this->getBlock();
        
        $vehicle = $this->createYMM();
        $this->insertMappingYMM( $vehicle->getLevel('year')->getId(), $vehicle->getLevel('make')->getId(), $vehicle->getLevel('model')->getId() );
        
        $request = $this->getRequest( array( 'make' => $vehicle->getLevel('make')->getId(), 'model' => $vehicle->getLevel('model')->getId(), 'year' => $vehicle->getLevel('year')->getId() ) );
        $block->setRequest($request);
        $this->setRequest($request);
        
        $actual = $block->listEntities( 'make' );
        $this->assertEquals( 1, count($actual) );
        $this->assertEquals( $vehicle->getLevel('make')->getId(), $actual[0]->getId(), 'if listing make in leaf first mode it returns the make in use' );
    }

    function testListModel()
    {
        $vehicle = $this->createYMM();
        $this->insertMappingYMM( $vehicle->getLevel('year')->getId(), $vehicle->getLevel('make')->getId(), $vehicle->getLevel('model')->getId() );
        $_GET['make'] = $vehicle->getLevel('make')->getId();
        $_GET['model'] = $vehicle->getLevel('model')->getId();
        $_GET['year'] = $vehicle->getLevel('year')->getId();
        $block = $this->getBlock();
        $actual = $block->listEntities( 'model' );
        $this->assertEquals( 1, count($actual) );
        $this->assertEquals( $vehicle->getLevel('model')->getId(), $actual[0]->getId(), 'if listing models in leaf first mode it returns the model in use' );
    }
    
    function getRequest( $params = array() )
    {
        $request = new Zend_Controller_Request_HttpTestCase();
        foreach( $params as $key => $val )
        {
            $request->setParam( $key, $val );
        }
        return $request;
    }
}
