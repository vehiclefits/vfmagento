<?php

class Elite_Vafdiagram_Model_ProductFinder
{

    function listProductIds($paramaters)
    {
	$select = $this->getReadAdapter()->select()
			->from('elite_product_servicecode', array('product_id'));
	$this->filter($select, $paramaters);
	$select->order('callout');
	$rs = $select->query()->fetchAll();
	$return = array();
	foreach ($rs as $result)
	{
	    $return[] = $result['product_id'];
	}
	return $return;
    }

    function listIllustrationIds($paramaters)
    {
	$select = $this->getReadAdapter()->select()
			->from('elite_product_servicecode', array('distinct(illustration_id)'))
			->order('illustration_id');
	$this->filter($select, $paramaters);
	$select->order('callout');
	$rs = $select->query()->fetchAll();
	$return = array();
	foreach ($rs as $result)
	{
	    $return[] = $result['illustration_id'];
	}
	return $return;
    }

    function filter($select, $paramaters)
    {
	$select->where('category1_id = ?', $paramaters['category1']);
	if (isset($paramaters['category2']))
	{
	    $select->where('category2_id = ?', $paramaters['category2']);
	}
	if (isset($paramaters['category3']))
	{
	    $select->where('category3_id = ?', $paramaters['category3']);
	}
	if (isset($paramaters['category4']))
	{
	    $select->where('category4_id = ?', $paramaters['category4']);
	}
	if (isset($paramaters['service_code']))
	{
	    $select->where('service_code = ?', $paramaters['service_code']);
	}
    }

    /** @return Zend_Db_Statement_Interface */
    protected function query($sql)
    {
	return $this->getReadAdapter()->query($sql);
    }

    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
	return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }

}