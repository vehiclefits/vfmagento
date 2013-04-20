<?php
class Elite_Vafwheeladapter_Model_Finder
{
	function listVehicleSideLugCounts()
    {
		return $this->listValues('elite_product_wheel','lug_count');   
    }
    
    function listVehicleSideSpread()
    {
        return $this->listValues('elite_product_wheel','bolt_distance');
    }
    
    function listWheelSideLugCounts()
    {
        return $this->listValues('elite_product_wheeladapter','lug_count');
    }
    
    function listWheelSideSpread()
    {
        return $this->listValues('elite_product_wheeladapter','bolt_distance');
    }
    
    function listValues( $table, $column )
    {
		$select = $this->getReadAdapter()->select()
            ->from($table, 'distinct(' . $column . ') as ' . $column )
            ->order($column);
        $result = $select->query();
        $return = array();
        while($row = $result->fetch())
        {
            $return[ (string)$row[$column] ] = $row[$column];
        }
        return $return;
    }
    
    /**
    * @param Elite_Vafwheel_Model_BoltPattern_Single $wheelBolt Wheel Side Bolt
    * @param Elite_Vafwheel_Model_BoltPattern_Single $vehicleBolt Vehicle Side Bolt
    * @return array of matching product ids
    */
    function getProductIds( $wheelBolt, $vehicleBolt )
    {
		if($vehicleBolt && !$wheelBolt)
		{
			return $this->getVehicleSideProductIds($vehicleBolt);
		}
		if($wheelBolt && !$vehicleBolt)
		{
			return $this->getWheelSideProductIds($wheelBolt);
		}		
		return array_intersect( $this->getVehicleSideProductIds($vehicleBolt), $this->getWheelSideProductIds($wheelBolt) );
    }
    
    function getVehicleSideProductIds( Elite_Vafwheel_Model_BoltPattern_Single $bolt)
    {
        $select = $this->getReadAdapter()->select()
            ->from('elite_product_wheel','distinct(entity_id) entity_id')
            ->where('lug_count = ?', $bolt->getLugCount() )
            ->where('bolt_distance = ?', $bolt->getDistance() );
        $result = $select->query();
        $return = array();
        while($row = $result->fetch())
        {
            array_push($return,$row['entity_id']);
        }
        return $return;
    }
    
    function getWheelSideProductIds( Elite_Vafwheel_Model_BoltPattern_Single $bolt)
    {
        $select = $this->getReadAdapter()->select()
            ->from('elite_product_wheeladapter','distinct(entity_id) entity_id')
            ->where('lug_count = ?', $bolt->getLugCount() )
            ->where('bolt_distance = ?', $bolt->getDistance() );
        $result = $select->query();
        $return = array();
        while($row = $result->fetch())
        {
            array_push($return,$row['entity_id']);
        }
        return $return;
    }
    
    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }
}