<?php
class Elite_Vafrelated_Model_Catalog_Product
{
    /** @var Elite_Vaf_Model_Catalog_Product */
    protected $wrappedProduct;

    function __construct(Elite_Vaf_Model_Catalog_Product $productToWrap )
    {
        $this->wrappedProduct = $productToWrap;
    }

    function relatedProducts($vehicle)
    {
	$select = $this->getReadAdapter()->select()
	    ->from($this->wrappedProduct->getSchema()->mappingsTable(),array('entity_id'))
	    ->where('entity_id != ' . $this->getId())
	    ->where('related = 1');
	 foreach($vehicle->toValueArray() as $level=>$id)
	 {
	     $select->where($level . '_id = ?', $id);
	 }
	 $productIds = array();
	 foreach( $select->query()->fetchAll() as $row )
	 {
	     $productIds[] = $row['entity_id'];
	 }
	 
	 return $productIds;
    }

    function showInRelated()
    {
	if(!$this->getId())
	{
	    return false;
	}
	$select = $this->getReadAdapter()->select()
	    ->from($this->wrappedProduct->getSchema()->mappingsTable(),array('related'))
	    ->where('entity_id = ' . $this->getId());
	
	return (bool)$select->query()->fetchColumn();
    }

    function setShowInRelated($value)
    {
	$select =  $this->getReadAdapter()->select()
	    ->from($this->wrappedProduct->getSchema()->mappingsTable(),array('count(*)'))
	    ->where('entity_id = ' . $this->getId());
	if( 0 == $select->query()->fetchColumn())
	{
	    $this->query(
		sprintf(
			"
		    REPLACE INTO
			`" . $this->wrappedProduct->getSchema()->mappingsTable() . "`
		    (
			`related`,
			`entity_id`
		    )
		    VALUES
		    (
			%d,
			%d
		    )
		    ",
			1,
			(int) $this->getId()
		    )
	    );
	}
	$this->query('UPDATE ' . $this->wrappedProduct->getSchema()->mappingsTable() . ' set related = ' . (int)$value . ' where entity_id = ' . (int)$this->getId() );
    }

    function __call($methodName,$arguments)
    {
        $method = array($this->wrappedProduct,$methodName);
        return call_user_func_array( $method, $arguments );
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