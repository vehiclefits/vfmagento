<?php
class Elite_Vafdiagram_Model_CategoryFinder
{
	function listCategories1($paramaters)
	{
		$select = $this->getReadAdapter()->select()
			->from('elite_product_servicecode')
			->where('product_id = ?', $paramaters['product']);
		if(isset($paramaters['service_code']))
		{
			$select->where('service_code = ?',$paramaters['service_code']);
		}
		$rs = $select->query()->fetchAll();
		$return = array();
		foreach($rs as $result)
		{
			$return[] = $result['category1_id'];
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