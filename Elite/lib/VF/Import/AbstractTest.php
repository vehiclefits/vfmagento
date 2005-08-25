<?php
class VF_Import_AbstractTest extends Elite_Vaf_TestCase
{
	protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
        
    }
    
    function testShouldGetProductId()
	{
		$import = new VF_Import_AbstractTestSubClass;
		$expectedProductId = $this->insertProduct('sku');
		$this->assertEquals( $expectedProductId, $import->productId('sku') );
	}
	
    function testRegression()
	{
		$import = new VF_Import_AbstractTestSubClass;
		$this->getReadAdapter()->query('update test_catalog_product_entity set sku=\'\' where 0');
		$expectedProductId = $this->insertProduct('sku');
		$this->assertEquals( $expectedProductId, $import->productId('sku') );
	}
}

class VF_Import_AbstractTestSubClass extends VF_Import_Abstract
{
	function __construct()
	{
		
	}
	
	function getProductTable()
	{
		return 'test_catalog_product_entity';
	}
}