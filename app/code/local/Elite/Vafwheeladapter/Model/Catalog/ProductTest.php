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
class Elite_Vafwheeladapter_Model_Catalog_ProductTest extends Elite_Vaf_TestCase
{ 
    function testCreateNewProduct()
    {
	$product = new Elite_Vaf_Model_Catalog_Product;
	$wheelAdapterProduct = new Elite_Vafwheeladapter_Model_Catalog_Product($product);
	$this->assertFalse( $wheelAdapterProduct->getWheelSideBoltPattern(), 'should create new product w/ no bolt patterns');
    }

    function testCreateNewProduct2()
    {
	$product = new Elite_Vaf_Model_Catalog_Product;
	$wheelAdapterProduct = new Elite_Vafwheeladapter_Model_Catalog_Product($product);
	$this->assertEquals( array(), $wheelAdapterProduct->getVehicleSideBoltPatterns(), 'should create new product w/ no bolt patterns');
    }

    function testWhenNoVehicleSide()
    {
        $product = $this->newWheeladapterProduct();
        $product->setId(1);
        $this->assertEquals( array(), $product->getVehicleSideBoltPatterns(), 'when product has no vehicle side bolt patterns should return emtpy array' );
    }
    
    function testWhenNoWheelSide()
    {
        $product = $this->newWheeladapterProduct();
        $product->setId(1);
        $this->assertFalse( $product->getWheelSideBoltPattern(), 'when product has no wheel side bolt pattern should return false' );
    }
    
    function testShouldHaveSingleVehicleSide()
    {
        $product = $this->newWheeladapterProduct();
        $product->setId(1);
        $product->addVehicleSideBoltPattern( $this->boltPattern('4x114.3') );
        
        $product = $this->newWheeladapterProduct();
        $product->setId(1);
        
        $boltPatterns = $product->getVehicleSideBoltPatterns();
        $this->assertEquals( 4, $boltPatterns[0]->getLugCount(), 'should be able to have single vehicle side bolt patterns' );
        $this->assertEquals( 114.3, $boltPatterns[0]->getDistance(), 'should be able to have single vehicle side bolt patterns' );
    }
    
    function testShouldHaveMultipleVehicleSide()
    {
        $product = $this->newWheeladapterProduct();
        $product->setId(1);
        $product->addVehicleSideBoltPattern( $this->boltPattern('4x114.3') );
        $product->addVehicleSideBoltPattern( $this->boltPattern('5x114.3') );
        
        $product = $this->newWheeladapterProduct();
        $product->setId(1);
        
        $boltPatterns = $product->getVehicleSideBoltPatterns();
        $this->assertEquals( 2, count($boltPatterns), 'should be able to have multiple vehicle side bolt patterns' );
    }
    
    function testShouldHaveOneWheelSide()
    {
		$product = $this->newWheeladapterProduct();
        $product->setId(1);
        
        $product->setWheelSideBoltPattern( $this->boltPattern('4x114.3') );
        
        $product = $this->newWheeladapterProduct();
        $product->setId(1);
        
        $boltPattern = $product->getWheelSideBoltPattern();
        $this->assertEquals( 4, $boltPattern->getLugCount(), 'should be able to have single wheel side bolt patterns' );
        $this->assertEquals( 114.3, $boltPattern->getDistance(), 'should be able to have single wheel side bolt patterns' );
    }
}