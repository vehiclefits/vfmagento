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
	return VF_Singleton::getInstance()->getReadAdapter();
    }

}