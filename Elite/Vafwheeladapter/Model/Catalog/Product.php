<?php
class Elite_Vafwheeladapter_Model_Catalog_Product extends Elite_Vafwheel_Model_Catalog_Product
{
	function getVehicleSideBoltPatterns()
	{
		return $this->getBoltPatterns();
	}
	
	function addVehicleSideBoltPattern( Elite_Vafwheel_Model_BoltPattern $boltPattern )
	{
		return $this->addBoltPattern($boltPattern);
	}
	
	function getWheelSideBoltPattern()
	{
		$select = $this->getReadAdapter()->select()
            ->from('elite_product_wheeladapter')
            ->where('entity_id=?',$this->getId())
            ->limit(1);
        $result = $select->query();
            
        $row = $result->fetchObject();
        if(!$row)
        {
			return false;
        }
        return Elite_Vafwheel_Model_BoltPattern::create($row->lug_count.'x'.$row->bolt_distance);
	}
	
	function setWheelSideBoltPattern( Elite_Vafwheel_Model_BoltPattern $boltPattern )
	{
		$sql = sprintf(
            "REPLACE INTO `elite_product_wheeladapter` ( `entity_id`, `lug_count`, `bolt_distance` ) VALUES ( %d, %d, %s )",
            $this->getId(),
            (int)$boltPattern->getLugCount(),
            (float)$boltPattern->getDistance()
        );
        $this->query($sql);
	}
	
	function unsetWheelSideBoltPattern()
	{
		$sql = sprintf(
            "DELETE FROM `elite_product_wheeladapter` WHERE `entity_id` = %d",
            $this->getId()
        );
        $this->query($sql);
	}
}