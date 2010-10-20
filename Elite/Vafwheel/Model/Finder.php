<?php
class Elite_Vafwheel_Model_Finder
{
    function listLugCounts()
    {
        $select = $this->getReadAdapter()->select()
            ->from('elite_product_wheel','distinct(lug_count) lug_count');
        $result = $select->query();
        $return = array();
        while($row = $result->fetch())
        {
            $return[ $row['lug_count'] ] = $row['lug_count'];
        }
        return $return;
    }
    
    function listSpread()
    {
        $select = $this->getReadAdapter()->select()
            ->from('elite_product_wheel','distinct(bolt_distance) bolt_distance');
        $result = $select->query();
        $return = array();
        while($row = $result->fetch())
        {
            $return[ (string)$row['bolt_distance'] ] = $row['bolt_distance'];
        }
        return $return;
    }
    
    function getProductIds( Elite_Vafwheel_Model_BoltPattern_Single $bolt)
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
    
    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }
}