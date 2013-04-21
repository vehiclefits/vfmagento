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