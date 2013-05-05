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

class Elite_Vafsitemap_Block_Vehicles extends Mage_Core_Block_Template implements VF_Configurable
{

    protected $perpage = 50;
    protected $page = 1;
    /** @var Zend_Config */
    protected $config;

    function _construct()
    {
	$this->page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    }

    function getConfig()
    {
	if (!$this->config instanceof Zend_Config)
	{
	    $this->config = VF_Singleton::getInstance()->getConfig();
	}
	return $this->config;
    }

    function setConfig(Zend_Config $config)
    {
	$this->config = $config;
    }

    function getVehicleUrl($vehicle)
    {
	$rewrite = new Elite_Vafsitemap_Model_Url_Rewrite;
	return $rewrite->getProductListingUrl($vehicle);
    }

    /** @todo move/rename this to definition finder -> find all in use() method */
    function getDefinitions($perPage=false, $offset=false)
    {
	$sitemap = new Elite_Vafsitemap_Model_Sitemap_Vehicle($this->getConfig());
	return $sitemap->getDefinitions($perPage, $offset);
    }

    protected function offset()
    {
	return ( $this->page * $this->perpage ) - $this->perpage;
    }

    /** @return integer total # of definitions in the sitemap */
    function count()
    {
	return $this->sitemap()->vehicleCount();
    }

    function start()
    {
	return 1 + $this->page * $this->perpage - $this->perpage;
    }

    function end()
    {
	$end = $this->start() + $this->perpage;
	if ($end > $this->count())
	{
	    $end = $this->count();
	} else
	{
	    $end = $end - 1;
	}
	return $end;
    }

    function prev()
    {
	return $this->page - 1;
    }

    function next()
    {
	return $this->page + 1;
    }

    function sitemap()
    {
	return new Elite_Vafsitemap_Model_Sitemap_Product_Html($this->getConfig());
    }

    protected function getSchema()
    {
	$schema = new VF_Schema();
	$schema->setConfig($this->getCOnfig());/** @todo potential linux bug needs regression test */
	return $schema;
    }

    /** @return Zend_Db_Statement_Interface */
    protected function query($sql, $bind = array())
    {
	return $this->getReadAdapter()->query($sql, $bind);
    }

    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
	return VF_Singleton::getInstance()->getReadAdapter();
    }

}
