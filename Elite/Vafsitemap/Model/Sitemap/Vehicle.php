<?php
class Elite_Vafsitemap_Model_Sitemap_Vehicle
{
    function getDefinitions()
    {
		$block = new Elite_Vafsitemap_Block_Vehicles;
		return $block->getDefinitions();
    }
    
    /** @return integer total # of definitions in the sitemap */
    function vehicleCount()
    {
        /** @todo move to definition finder */
        $result = $this->query( "select count(distinct(`".$this->getSchema()->getLeafLevel()."_id`)) from `elite_Fitment`" );
        $count = $result->fetchColumn();
        return $count;
    }
    
    /** @return Zend_Db_Statement_Interface */
    protected function query( $sql, $bind = array() )
    {
        return $this->getReadAdapter()->query( $sql, $bind );
    }
    
    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }
    
    protected function getSchema()
    {
        return new Elite_Vaf_Model_Schema();
    }
}