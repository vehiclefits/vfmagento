<?php
class Elite_Vafsitemap_Model_Url_Rewrite extends Mage_Core_Model_Url_Rewrite
{
    protected $uri;
    
    function rewrite(Zend_Controller_Request_Http $request=null, Zend_Controller_Response_Http $response=null) 
    {
        if (is_null($request)) {
            $request = Mage::app()->getFrontController()->getRequest();
        }
        if (is_null($response)) {
            $response = Mage::app()->getFrontController()->getResponse();
        }
        
        $this->request = $request;
        $this->uri = $request->getRequestUri();
        
        if( $this->isProductListingRequest() )
        {
            return $this->rewriteProductListing();
        }
        
        if( $this->isVehicleProductRequest() )
        {
            $this->rewriteVehicleProductRequest();
        }
        
        return parent::rewrite($request,$response);
    }
    
    function isProductListingRequest()
    {
        return preg_match( '#/vafsitemap/products/#', $this->uri, $matches );
    }
    
    function rewriteProductListing()
    {
        preg_match( '#/vafsitemap/products/([^/]*)/$#', $this->uri, $matches );
        if(!isset($matches[1]))
        {
			return false;
        }
        $vehicleSlug = $matches[1];
        $vehicle = $this->slugToVehicle($vehicleSlug);
        if(!$vehicle)
        {
            return false;
        }
        $this->rewriteTo('/vafsitemap/product/index',$vehicle);
        return true;
    }
    
    function getProductListingUrl($vehicle)
    {
		return 'vafsitemap/products/'.$this->vehicleSlug($vehicle).'/';
    }

    function isVehicleProductRequest()
    {
        return preg_match( '#/fit/([^/]*)/#', $this->uri, $matches );
    }
    
    function rewriteVehicleProductRequest()
    {
        preg_match( '#/fit/([^/]*)/(.*).html$#', $this->uri, $matches );
        if(!isset($matches[1]))
        {
            return false;
        }
        $vehilceSlug = $matches[1];
        $productSlug = $matches[2];
        $vehicle = $this->slugToVehicle($vehilceSlug);
        if(!$vehicle)
        {
            return false;
        }
        $this->rewriteTo('/'.$productSlug.'.html',$vehicle);
        return true;
    }
    
    function rewriteTo( $pathInfo, $vehicle )
    {
        $this->request->setPathInfo($pathInfo);
        $this->request->setParams($vehicle->toValueArray() );
    }
    
    /**
    * @param string ymm string "honda~civic~2002"
    * @return Elite_Vaf_Model_Vehicle
    */
    function slugToVehicle($vehicleSlug)
    {
        $slug = new Vafsitemap_Model_Url_Rewrite_Slug();
        return $slug->slugToVehicle($vehicleSlug);
    }

    function getRequestPathRewritten()
    {
        $vehicle = Elite_Vaf_Helper_Data::getInstance()->getFit();
        return $this->getRequestPathForDefinition($vehicle);
    }
    
    function getRequestPathForDefinition($vehicle)
    {
        $path = parent::getData( 'url_path' );
        if( !$vehicle || !$this->getData( 'product_id' ))
        {
            return $this->getRequestPath();
        }
        $schema = new Elite_Vaf_Model_Schema();
        
        $path = 'fit/'.$this->vehicleSlug($vehicle) . '/' . $path;
        return $path;
    }
    
    function vehicleSlug($vehicle)
    {
		$slug = implode('~',$vehicle->toTitleArray());
		$slug = str_replace(' ','-',$slug);
		return $slug;
    }
    
    function getSchema()
    {
        return new Elite_Vaf_Model_Schema;
    }
}