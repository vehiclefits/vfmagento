<?php 
class Elite_Vafdiagram_Model_ProductFinder
{
	function listProductIds($category1, $category2=null)
	{
		$select = $this->getReadAdapter()->select()
			->from('elite_product_servicecode', array('product_id'))
			->where('category1_id = ?', $category1);
		if($category2)
		{
			$select->where('category2_id = ?', $category2);
		}
		$rs = $select->query()->fetchAll();
		$return = array();
		foreach($rs as $result)
		{
			$return[] = $result['product_id'];
		}
		return $return;
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