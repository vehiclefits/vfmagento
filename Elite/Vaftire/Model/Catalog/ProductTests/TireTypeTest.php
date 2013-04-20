<?php
class Elite_Vaftire_Model_Catalog_ProductTests_TireTypeTest extends Elite_Vaf_TestCase
{
	function testNoTireType()
	{
		$this->assertFalse( $this->newTireProduct(1)->tireType(), 'should have no tire type' );
	}
	
	function testSetToWinter()
	{
		$product = $this->newTireProduct(1);
		$product->setTireType( Elite_Vaftire_Model_Catalog_Product::WINTER );
		$this->assertEquals( Elite_Vaftire_Model_Catalog_Product::WINTER, $this->newTireProduct(1)->tireType(), 'should set tire type' );
	}
	
	function testSetToSummer()
	{
		$product = $this->newTireProduct(1);
		$product->setTireType( Elite_Vaftire_Model_Catalog_Product::SUMMER_ALL );
		$this->assertEquals( Elite_Vaftire_Model_Catalog_Product::SUMMER_ALL, $this->newTireProduct(1)->tireType(), 'should set tire type' );
	}
	
	function testSetAndUnset()
	{
		$product = $this->newTireProduct(1);
		$product->setTireType( Elite_Vaftire_Model_Catalog_Product::WINTER );
		$product->setTireType(false);
		$this->assertFalse( $this->newTireProduct(1)->tireType(), 'should set & unset tire type' );
	}
	
	function testDoesntInterfereWithTireSize()
	{
		$product = $this->newTireProduct(1);
		$product->setTireSize( new Elite_Vaftire_Model_TireSize(205,55,16) );
		$product->setTireType( Elite_Vaftire_Model_Catalog_Product::WINTER );
		$product->setTireSize( false );
		$this->assertFalse( $this->newTireProduct(1)->tireType(), 'should set & unset tire type' );
	}
}