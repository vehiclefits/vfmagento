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
class Elite_Vaf_Model_Catalog_ProductTests_ApplicationFitmentsTests_GetFitsTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{
	const PRODUCT_ID = 1;
    const PRODUCT_NAME = 'Widget';
    
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testGetFitsStartsEmpty()
    {
        $product = $this->getProduct();
        $this->assertEquals( array(), $product->getFits() );
    }
    
    function testGetFits()
    {
        $product = $this->getProduct(self::PRODUCT_ID);
        $vehicle = $this->createMMY();
        $product->addVafFit( $vehicle->toValueArray() );
        
        $actual = $product->getFits();
        $this->assertEquals( 1, count($actual) );
        $fit = $actual[0];
        $this->assertEquals( $vehicle->toValueArray(), array('make'=>$fit->make_id,'model'=>$fit->model_id,'year'=>$fit->year_id), 'should get fitment' );
    }
    
    function testIsRepeatable()
    {
        $product = $this->getProduct(self::PRODUCT_ID);
        $product->addVafFit( $this->createMMY()->toValueArray() );
        $this->assertSame( $product->getFits(), $product->getFits(), 'method call should be repeatable' );
    }
    
    function testGetFitModels()
    {
        $product = $this->getProduct(self::PRODUCT_ID);
        $vehicle = $this->createMMY();
        $product->addVafFit($vehicle->toValueArray());
        
        $actual = $product->getFitModels();
        $this->assertEquals( 1, count($actual) );
        $fit = $actual[0];
        $this->assertEquals( $vehicle->toValueArray(), $fit->toValueArray(), 'should get fitments as models' );
    }
}