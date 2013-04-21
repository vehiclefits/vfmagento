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
class Elite_Vaftire_Observer_ProductTireSizeBinderTest extends Elite_Vaf_TestCase
{
    const ID = 1;
    
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testIsSilentWhenNoTireSizePassed()
    {
        $event = $this->event(new Elite_Vaf_Model_Catalog_Product);
        $this->productTireBinder()->setTireSize( $event );
    }
    
    function testSetTireSize()
    {
        $product = $this->newProduct(self::ID);
        $this->setRequestParams( array('section_width'=>'205', 'aspect_ratio'=>'55', 'diameter'=>16) );
        $this->bindTireSize( $product );
        
        $tireProduct = $this->newTireProduct(self::ID);
        $this->assertEquals( '205/55-16', $tireProduct->getTireSize()->__toString(), 'should set a products tire size' );
    }
     
    function testUnsetTireSize()
    {
        $product = $this->newProduct(self::ID);
        $this->setRequestParams( array('section_width'=>'205', 'aspect_ratio'=>'55', 'diameter'=>16) );
        $this->bindTireSize( $product );
        
        $this->setRequestParams( array('section_width'=>'', 'aspect_ratio'=>'', 'diameter'=>'') );
        $this->bindTireSize( $product );
        
        $tireProduct = $this->newTireProduct(self::ID);
        $this->assertFalse( $tireProduct->getTireSize(), 'should be able to unassign tire size' );
    }
    
    function testSetTireType()
    {
		$product = $this->newProduct(self::ID);
        $this->setRequestParams( array('tire_type'=>Elite_Vaftire_Model_Catalog_Product::SUMMER_ALL) );
        $this->bindTireSize( $product );
        
        $tireProduct = $this->newTireProduct(self::ID);
        $this->assertEquals( Elite_Vaftire_Model_Catalog_Product::SUMMER_ALL, $tireProduct->tireType(), 'should be able to assign tire type' );
    }
    
    function testWhenSetTireSizeShouldBindVehicle()
    {
        $vehicle = $this->createTireMMY('Honda','Civic','2000');
        $vehicle->addTireSize( Elite_Vaftire_Model_TireSize::create('205/55-16') );
        
        $product = $this->newProduct(self::ID);
        $this->setRequestParams( array('section_width'=>'205', 'aspect_ratio'=>'55', 'diameter'=>16) );
        $this->bindTireSize( $product );
        
        $tireProduct = $this->newTireProduct(self::ID);
        $this->assertEquals( 1, count($tireProduct->getFits()), 'should add vehicles for a product via its tire size' );
    }
    
    function bindTireSize($product)
    {
        $event = $this->event($product);
        $this->productTireBinder()->setTireSize( $event );
    }
    
    function event($product)
    {
        $event = new stdClass;
        $event->controller = new Elite_Vaf_MockController;
        $event->product = $product;
        return $event;
    }
    
    function productTireBinder()
    {
        return new Elite_Vaftire_Observer_ProductTireSizeBinder;
    }
}
