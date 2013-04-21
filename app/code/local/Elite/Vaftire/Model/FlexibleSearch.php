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

class Elite_Vaftire_Model_FlexibleSearch extends VF_FlexibleSearch_Wrapper implements VF_FlexibleSearch_Interface
{

    protected $config;
    
    function storeTireSizeInSession()
    {
	if ($this->shouldClear())
	{
	    return $this->clear();
	}
	$this->clearSelection();
	$wheelSearch = new Elite_Vafwheel_Model_FlexibleSearch($this);
	$wheelSearch->clear();
	$_SESSION['section_width'] = $this->getParam('section_width');
	$_SESSION['aspect_ratio'] = $this->getParam('aspect_ratio');
	$_SESSION['diameter'] = $this->getParam('diameter');
	$_SESSION['tire_type'] = $this->getParam('tire_type');
    }

    function shouldClear()
    {
	return 0 == $this->sectionWidth() && 0 == $this->aspectRatio() && 0 == $this->diameter();
    }

    function clear()
    {
	unset($_SESSION['section_width']);
	unset($_SESSION['aspect_ratio']);
	unset($_SESSION['diameter']);
	unset($_SESSION['tire_type']);
    }

    function doGetProductIds()
    {
	if ($this->hasNoRequest())
	{
	    return $this->wrappedFlexibleSearch->doGetProductIds();
	}

	$finder = new Elite_Vaftire_Model_Finder();
	$productIds = $finder->productIds($this->tireSize(), $this->tireType());
	if (array() == $productIds)
	{
	    return array(0);
	}
	return $productIds;
    }

    function hasNoRequest()
    {
	return!$this->sectionWidth() || !$this->aspectRatio() || !$this->diameter();
    }

    function sectionWidth()
    {
	if ($this->vehicleSelection())
	{
	    $this->setSizeFromVehicle();
	}
	return $this->getParam('section_width');
    }

    function aspectRatio()
    {
	if ($this->vehicleSelection())
	{
	    $this->setSizeFromVehicle();
	}
	return $this->getParam('aspect_ratio');
    }

    function diameter()
    {
	if ($this->vehicleSelection())
	{
	    $this->setSizeFromVehicle();
	}
	return $this->getParam('diameter');
    }

    function tireSize()
    {
	return new Elite_Vaftire_Model_TireSize($this->sectionWidth(), $this->aspectRatio(), $this->diameter());
    }

    function tireType()
    {
	return!$this->getParam('tire_type') ? null : $this->getParam('tire_type');
    }

    function setSizeFromVehicle()
    {
	if(!is_null($this->getConfig()->tire->populateWhenSelectVehicle) && $this->getConfig()->tire->populateWhenSelectVehicle === '' )
	{
	    return;
	}
	$vehicle = $this->vehicleSelection();
	$select = $this->getReadAdapter()->select()
			->from('elite_vehicle_tire', array('section_width', 'diameter', 'aspect_ratio'))
			->where('leaf_id = ?', $vehicle->getLeafValue())
			->limit(1);
	$rs = $select->query()->fetch();
	$_SESSION['section_width'] = $rs['section_width'];
	$_SESSION['diameter'] = $rs['diameter'];
	$_SESSION['aspect_ratio'] = $rs['aspect_ratio'];
    }

    function getConfig()
    {
	if (!$this->config instanceof Zend_Config)
	{
	    $this->config = Elite_Vaf_Helper_Data::getInstance()->getConfig();
	}
	return $this->config;
    }

    function setConfig(Zend_Config $config)
    {
	$this->config = $config;
    }
}