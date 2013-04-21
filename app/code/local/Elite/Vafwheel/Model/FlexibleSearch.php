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

class Elite_Vafwheel_Model_FlexibleSearch extends VF_FlexibleSearch_Wrapper implements VF_FlexibleSearch_Interface
{

    function doGetProductIds()
    {
	if (!$this->lugCount() || !$this->studSpread())
	{
	    return $this->wrappedFlexibleSearch->doGetProductIds();
	}

	$finder = new Elite_Vafwheel_Model_Finder();
	$productIds = $finder->getProductIds($this->boltPattern());
	if (array() == $productIds)
	{
	    return array(0);
	}
	return $productIds;
    }

    function boltPattern()
    {
	return Elite_Vafwheel_Model_BoltPattern::create($this->boltString());
    }

    function boltString()
    {
	return $this->lugCount() . 'x' . $this->studSpread();
    }

    function storeSizeInSession()
    {
	if ($this->shouldClear())
	{
	    $this->clear();
	}
	if (!$this->lugCount() || !$this->studSpread())
	{
	    return;
	}
	$this->clearSelection();
	$tireSearch = new Elite_Vaftire_Model_FlexibleSearch($this);
	$tireSearch->clear();
	$_SESSION['lug_count'] = $this->lugCount();
	$_SESSION['stud_spread'] = $this->studSpread();
    }

    function shouldClear()
    {
	return 0 == (int) $this->lugCount() && 0 == (int) $this->studSpread();
    }

    function clear()
    {
	unset($_SESSION['lug_count']);
	unset($_SESSION['stud_spread']);
    }

    function lugCount()
    {
	return $this->getParam('lug_count');
    }

    function studSpread()
    {
	return $this->getParam('stud_spread');
    }

}