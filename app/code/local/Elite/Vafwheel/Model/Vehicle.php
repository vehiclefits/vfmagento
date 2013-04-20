<?php
class Elite_Vafwheel_Model_Vehicle
{
    /** @var VF_Vehicle */
    protected $wrappedVehicle;
    
    function __construct(VF_Vehicle $vehicle )
    {
        $this->wrappedVehicle = $vehicle;
    }
    
    function __call($methodName,$arguments)
    {
        $method = array($this->wrappedVehicle,$methodName);
        return call_user_func_array( $method, $arguments );
    }
    
    function addBoltPattern( Elite_Vafwheel_Model_BoltPattern_Single $boltPattern )
    {
        $this->query( sprintf(
            "REPLACE INTO `elite_definition_wheel` ( `leaf_id`, `lug_count`, `bolt_distance`, `offset` ) VALUES ( %d, %d, %s, %s )",
            $this->getLeafValue(),
            (int)$boltPattern->getLugCount(),
            (float)$boltPattern->getDistance(),
            (float)$boltPattern->getOffset()
        ));
    }
    
    /** @return Elite_Vafwheel_Model_BoltPattern_Single */
    function boltPattern()
    {
        $r = $this->query( sprintf(
            "
            SELECT lug_count, bolt_distance, offset
            FROM elite_definition_wheel
            WHERE leaf_id = %d
            ",
            (int)$this->wrappedVehicle->getLeafValue()
        ));
        return $r->fetchObject();
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
