<?php
abstract class Elite_Vafsitemap_Model_Url_RewriteTests_ProductListTests_GeneratesURLS_TestCase extends Elite_Vafsitemap_Model_Url_RewriteTests_TestCase
{
	function rewrite($productId,$urlPath,$vehicle)
    {
		$this->setVehicleRequest($vehicle);
		
		$rewrite = new Elite_Vafsitemap_Model_Url_RewriteTests_Subclass;
        $rewrite->setData( 'product_id', $productId );
        $rewrite->setData( 'url_path', $urlPath );        
        return $rewrite;
    }   
    
    function setVehicleRequest($vehicle)
    {
		$request = $this->getSEORequest('http://example.com/vafsitemap/products/honda~civic~2000/');
		$request->setParams($vehicle->toValueArray());
		$this->setRequest($request);
    }
}