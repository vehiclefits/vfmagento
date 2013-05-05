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
class Elite_Vafdiagram_Model_CategoryFinder
{
	function listCategories($paramaters)
	{
		$paramaters['level'] = 1;
		for($level=1; $level<=4; $level++)
		{
			if(isset($paramaters['level'.$level]) && $paramaters['level'.$level])
			{
				$paramaters['level'] = $level+1;
			}
		}
		
		$col = 'category' . $paramaters['level'] . '_id';
		$expr = "distinct($col)";
		
		$select = $this->getReadAdapter()->select()
			->from('elite_product_servicecode', array($expr));
		if(isset($paramaters['product']))
		{
			$select->where('product_id = ?', $paramaters['product']);
		}
		$this->filterByParents($select, $paramaters);
		if(isset($paramaters['service_code']))
		{
			$select->where('service_code = ?',$paramaters['service_code']);
		}
		$rs = $select->query()->fetchAll();
		$return = array();
		foreach($rs as $result)
		{
			$id = $this->getCategoryIdFromResult($result,$paramaters);
			if(!$id) continue;
			
			$return[] = $id;
		}
		return $return;
	}
	
	function getCategoryIdFromResult($result,$paramaters)
	{
		return $result['category' . $paramaters['level'] . '_id'];		
	}
	
	function filterByParents($select,$paramaters)
	{
		for($level=1; $level<=4; $level++)
		{
			if(isset($paramaters['level'.$level]) && $paramaters['level'.$level])
			{
				$select->where('category'.$level.'_id =?', $paramaters['level'.$level]);
			}
		}
	}
	
	/** @return Zend_Db_Statement_Interface */
    protected function query( $sql )
    {
        return $this->getReadAdapter()->query( $sql );
    }
    
    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return VF_Singleton::getInstance()->getReadAdapter();
    }
}