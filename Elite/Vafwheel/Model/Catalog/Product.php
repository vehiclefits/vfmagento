<?php
class Elite_Vafwheel_Model_Catalog_Product
{
	/** @var Elite_Vaf_Model_Catalog_Product */
    protected $wrappedProduct;
    
    function __construct(Elite_Vaf_Model_Catalog_Product $productToWrap )
    {
        $this->wrappedProduct = $productToWrap;
    }
    
    function addBoltPattern( Elite_Vafwheel_Model_BoltPattern $boltPattern )
    {
        $sql = sprintf(
            "REPLACE INTO `elite_product_wheel` ( `entity_id`, `lug_count`, `bolt_distance` ) VALUES ( %d, %d, %s )",
            $this->getId(),
            (int)$boltPattern->getLugCount(),
            (float)$boltPattern->getDistance()
        );
        $this->query($sql);
        $this->insertMappings($boltPattern);
    }
    
    function getBoltPatterns()
    {
	if(!$this->getId())
	{
	    return array();
	}
        $select = $this->getReadAdapter()->select()
            ->from('elite_product_wheel')
            ->where('entity_id=?',$this->getId());
        $result = $select->query();
            
        $return = array();
        while( $row = $result->fetchObject() )
        {
            $bolt = Elite_Vafwheel_Model_BoltPattern::create($row->lug_count.'x'.$row->bolt_distance);
            array_push($return,$bolt);
        }
        $result->closeCursor();
        
        return $return;
    }
    
    function removeBoltPatterns()
    {
        $this->getReadAdapter()->query(sprintf("DELETE FROM `elite_product_wheel` WHERE `entity_id` = %d",$this->getId()));
    }
    
    function insertMappings( Elite_Vafwheel_Model_BoltPattern $boltPattern )
    {
        $q = sprintf(
            "
            SELECT DISTINCT(`leaf_id`) as leaf_id
            FROM `elite_definition_wheel`
            WHERE `bolt_distance` = %s
            AND `lug_count` = %d
            AND `offset` >= %s
            AND `offset` <= %s
            ",
            (float)$boltPattern->getDistance(),
            (float)$boltPattern->getLugCount(),
            (float)$boltPattern->offsetMin(),
            (float)$boltPattern->offsetMax()
        );
        
        $result = $this->query( $q );
        
        $years = array();
        
        $rows = $result->fetchAll( Zend_Db::FETCH_OBJ );
        foreach($rows as $row)
        {
            $vehicle = $this->definition( $row->leaf_id );
            $this->insertMapping($vehicle);
        }
    }
    
    function definition($leaf_id)
    {
		$vehicleFinder = new Elite_Vaf_Model_Vehicle_Finder( new Elite_Vaf_Model_Schema() );
		return $vehicleFinder->findByLeaf($leaf_id);
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