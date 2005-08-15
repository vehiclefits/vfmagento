<?php
class Elite_Vafsitemap_Model_Sitemap_Product_HtmlTest extends Elite_Vaf_TestCase
{
    protected $expectedDefinition;
    protected $sitemap;
    
    function doSetUp()
    {
		$this->switchSchema('make,model,year');
		$this->expectedDefinition = $this->createMMY();
        $this->setRequestParams( $this->expectedDefinition->toValueArray() );
        $this->sitemap = new Elite_Vafsitemap_Model_Sitemap_Product_Sub( Elite_Vaf_Helper_Data::getInstance()->getConfig() );
    }
    
    function testSelectedVehicle()
    {
        $this->assertVehiclesSame( $this->sitemap->getSelectedDefinition(), $this->expectedDefinition, 'should find the currently selected vehicle' );
    }
    
    function testFiltersByVehicle()
    {
		$this->sitemap->getCollection();
        $this->assertTrue($this->sitemap->filtered, 'should filter the product collection by the selected vehicle');
    }
    
    function testProductCollectionEmpty()
    {
		$this->assertEquals( array(0), $this->sitemap->getCollection()->ids, 'when there are no mappings should find no products' );
    }
    
    function testProducts()
    {
		$productId = $this->insertProduct('sku');
		$this->insertMappingMMY($this->expectedDefinition,$productId);
		$this->assertEquals( array($productId), $this->sitemap->getCollection()->ids, 'when there are mappings should find products' );
    }
}

class Elite_Vafsitemap_Model_Sitemap_Product_Sub extends Elite_Vafsitemap_Model_Sitemap_Product_Html
{
	function doCollection()
    {
		$collection = new FakeCollection; 
        return $collection;
    }
}

class FakeCollection
{
	public $ids;
	
	function addIdFilter($ids)
	{
		$this->ids = $ids;
	}
}