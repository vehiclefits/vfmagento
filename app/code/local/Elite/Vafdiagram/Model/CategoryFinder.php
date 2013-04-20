<?php
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
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }
}