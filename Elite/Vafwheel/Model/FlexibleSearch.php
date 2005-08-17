<?php

class Elite_Vafwheel_Model_FlexibleSearch extends Elite_Vaf_Model_FlexibleSearch_Wrapper implements Elite_Vaf_Model_FlexibleSearch_Interface
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