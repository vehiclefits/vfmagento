<?php 
class Elite_Vafdiagram_Model_CategoryFinderTest extends Elite_Vafdiagram_Model_TestCase
{
	function testShouldFilterByProduct()
	{
		$productId1 = $this->insertProduct('sku1');
		$productId2 = $this->insertProduct('sku2');
		
		$this->importProductServiceCodes('sku,category1,category2,category3,category4,illustration_id,service_code' . "\n" .
										 'sku1,5,2,3,4,1234,123' . "\n" . 
										 'sku2,6,2,3,5,4567,456');		
		
		$finder = new Elite_Vafdiagram_Model_CategoryFinder;
		
		$actual = $finder->listCategories1(array(
			'product'=>$productId1
		));
		$this->assertEquals( array(5), $actual, 'should filter categories by product');
	}
	
	function testShouldFilterByServiceCode()
	{
		$productId1 = $this->insertProduct('sku1');
		
		$this->importProductServiceCodes('sku,category1,category2,category3,category4,illustration_id,service_code' . "\n" .
										 'sku1,5,2,3,4,1234,123' . "\n" . 
										 'sku1,6,2,3,5,4567,456');		
		
		$finder = new Elite_Vafdiagram_Model_CategoryFinder;
		
		$actual = $finder->listCategories1(array(
			'product'=>$productId1,
			'service_code'=>123
		));
		$this->assertEquals( array(5), $actual, 'should filter categories by service code');
	}
}