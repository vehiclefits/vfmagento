<?php
class Elite_Vafsitemap_Model_Sitemap_Vehicle
{
    protected $config;

    function __construct($config)
    {
	$this->config = $config;
    }

    function getDefinitions()
    {
		$block = new Elite_Vafsitemap_Block_Vehicles;
		return $block->getDefinitions();
    }
    
    /** @return integer total # of definitions in the sitemap */
    function vehicleCount()
    {
	$col = 'count(distinct(CONCAT(';
	$colParams = array();
	foreach($this->getSchema()->getRewriteLevels() as $level)
	{
	    $colParams[] = $level . '_id';
	}
	$col .= implode(',\'/\',', $colParams);
	$col .= ')))';

	$select = $this->getReadAdapter()->select()
			->from('elite_mapping', array($col));
	
	$result = $select->query();
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
        $schema = new Elite_Vaf_Model_Schema();
	$schema->setConfig($this->config);
	return $schema;
    }
}