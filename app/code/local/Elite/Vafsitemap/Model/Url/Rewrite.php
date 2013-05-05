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
 * to sales@vehiclefits.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.
 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Elite_Vafsitemap_Model_Url_Rewrite extends Mage_Core_Model_Url_Rewrite
{

    protected $uri, $config;

    function rewrite(Zend_Controller_Request_Http $request = null, Zend_Controller_Response_Http $response = null)
    {
        if (is_null($request)) {
            $request = Mage::app()->getFrontController()->getRequest();
        }
        if (is_null($response)) {
            $response = Mage::app()->getFrontController()->getResponse();
        }

        $this->request = $request;
        $this->uri = $request->getRequestUri();

        if ($this->isProductListingRequest()) {
            return $this->rewriteProductListing();
        }

        if ($this->isVehicleProductRequest()) {
            $this->rewriteVehicleProductRequest();
        }

        return parent::rewrite($request, $response);
    }

    function isProductListingRequest()
    {
        return preg_match('#/vafsitemap/products/#', $this->uri, $matches);
    }

    function rewriteProductListing()
    {
        preg_match('#/vafsitemap/products/([^/]*)/$#', $this->uri, $matches);
        if (!isset($matches[1])) {
            return false;
        }
        $vehicleSlug = $matches[1];
        $vehicle = $this->slugToVehicle($vehicleSlug);
        if (!$vehicle) {
            return false;
        }
        $this->rewriteTo('/vafsitemap/product/index', $vehicle);
        return true;
    }

    function getProductListingUrl($vehicle)
    {
        return 'vafsitemap/products/' . $this->vehicleSlug($vehicle) . '/';
    }

    function isVehicleProductRequest()
    {
        return preg_match('#/fit/([^/]*)/#', $this->uri, $matches);
    }

    function rewriteVehicleProductRequest()
    {
        preg_match('#/fit/([^/]*)/(.*).html#', $this->uri, $matches);
        if (!isset($matches[1])) {
            return false;
        }
        $vehicleSlug = $matches[1];
        $productSlug = $matches[2];
        $vehicle = $this->slugToVehicle($vehicleSlug);
        if (!$vehicle) {
            return false;
        }
        $this->rewriteTo('/' . $productSlug . '.html', $vehicle);
        return true;
    }

    function rewriteTo($pathInfo, $vehicle)
    {
        $this->request->setPathInfo($pathInfo);
        $this->request->setParams($vehicle->toValueArray());
    }

    /**
     * @param string ymm string "honda~civic~2002"
     * @return VF_Vehicle
     */
    function slugToVehicle($vehicleSlug)
    {
        $slug = new Elite_Vafsitemap_Model_Url_Rewrite_Slug();
        $slug->setConfig($this->getConfig());
        return $slug->slugToVehicle($vehicleSlug);
    }

    function getRequestPathRewritten()
    {
        $vehicle = VF_Singleton::getInstance()->vehicleSelection();
        return $this->getRequestPathForDefinition($vehicle);
    }

    function getRequestPathForDefinition($vehicle)
    {
        $path = parent::getData('url_path');
        if (!$vehicle || !$this->getData('product_id')) {
            return $this->getRequestPath();
        }
        $schema = new VF_Schema();

        $path = 'fit/' . $this->vehicleSlug($vehicle) . '/' . $path;
        return $path;
    }

    function vehicleSlug($vehicle)
    {
        $config = $this->getConfig();
        $rewriteLevels = $config->seo->rewriteLevels;
        if ($rewriteLevels) {
            $rewriteLevels = explode(',', $rewriteLevels);
            $slug = implode('~', $vehicle->toTitleArray($rewriteLevels));
        } else {
            $slug = implode('~', $vehicle->toTitleArray());
        }
        $slug = str_replace(' ', '-', $slug);

        $slug = str_replace('%7E', '~', urlencode($slug)); // url encode everything but tildes

        return $slug;
    }

    function getSchema()
    {
        return new VF_Schema;
    }

    function getConfig()
    {
        if (!$this->config instanceof Zend_Config) {
            $this->config = VF_Singleton::getInstance()->getConfig();
        }
        return $this->config;
    }

    function setConfig(Zend_Config $config)
    {
        $this->config = $config;
    }

}