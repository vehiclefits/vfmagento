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
class Elite_Vaf_Model_Catalog_ProductTests_ApplicationFitmentsTests_AddTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{
	const PRODUCT_ID = 1;
    const PRODUCT_NAME = 'Widget';
    
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testAddSingle()
    {
        $product = $this->getProduct(self::PRODUCT_ID);
        $vehicle = $this->createMMY();
        $mapping_id = $product->addVafFit( $vehicle->toValueArray() );
        
        $actualRow = $this->getMappingRow( array('make_id'=>$vehicle->getLevel('make')->getId(),'model_id'=>$vehicle->getLevel('model')->getId(),'year_id'=>$vehicle->getLevel('year')->getId()));
        $this->assertEquals( $vehicle->getLevel('make')->getId(), $actualRow['make_id'] );
        $this->assertEquals( $vehicle->getLevel('model')->getId(), $actualRow['model_id'] );
        $this->assertEquals( $vehicle->getLevel('year')->getId(), $actualRow['year_id'] );
        $this->assertEquals( self::PRODUCT_ID, $actualRow['entity_id'] );
        
        $this->assertTrue( $product->fitsVehicle($vehicle) );
    }
    
    function testAddMultiple()
    {
        $product = $this->getProduct(self::PRODUCT_ID);

        $vehicle1 = $this->createMMY('Make', 'Model1');
        $vehicle2 = $this->createMMY('Make', 'Model2');

        $mapping_id = $product->addVafFit( array('make'=>$vehicle1->getLevel('make')->getId()) );    
        
        $actual = $product->getFitModels();
        
        $this->assertEquals( 2, count($actual) );
        $fit1 = $actual[0];
        $fit2 = $actual[1];
        $this->assertEquals( $vehicle1->getLevel('model')->getId(), $fit1->getLevel('model')->getId() );
        $this->assertEquals( $vehicle2->getLevel('model')->getId(), $fit2->getLevel('model')->getId() );
    }
    
    function testShouldNotAcceptDuplicates()
    {
        $product = $this->getProduct(self::PRODUCT_ID);

        $vehicle1 = $this->createMMY('Make', 'Model1');
        
        $mapping_id1 = $product->addVafFit( $vehicle1->toValueArray() );    
        $mapping_id2 = $product->addVafFit( $vehicle1->toValueArray() );    
        
        $actual = $product->getFitModels();
        $this->assertEquals( 1, count($actual) );
        
        $this->assertTrue($mapping_id1 > 0, 'first time a mapping is inserted it gets an id');
        $this->assertEquals( $mapping_id1, $mapping_id2, 'if trying to insert duplicate mapping return the existing mapping id');
    }
}