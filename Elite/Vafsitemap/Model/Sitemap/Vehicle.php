<?php

class Elite_Vafsitemap_Model_Sitemap_Vehicle extends VafVehicle_Import_Abstract
{

    protected $config;
    protected $schema;

    function __construct($config)
    {
        $this->schema = new Elite_Vaf_Model_Schema;
	$this->config = $config;
    }

    /** @todo move/rename this to definition finder -> find all in use() method */
    function getDefinitions($perPage=false, $offset=false, $productId = null)
    {
	$return = array();
	$vehicleFinder = new Elite_Vaf_Model_Vehicle_Finder($this->getSchema());
	$vehicles = $this->doGetDefinitions($perPage, $offset, $productId);
	foreach ($vehicles as $vehicleStdClass)
	{
	    $vehicle = $vehicleFinder->findOneByLevelIds($vehicleStdClass, Elite_Vaf_Model_Vehicle_Finder::EXACT_ONLY);
	    array_push($return, $vehicle);
	}
	return $return;
    }

    function doGetDefinitions($perPage, $offset, $productId=null)
    {
	$rewriteLevels = $this->getSchema()->getRewriteLevels();
	
	$db = $this->getReadAdapter();

	$cols = array();
	foreach ($this->getSchema()->getRewriteLevels() as $col)
	{
	    $cols[] = $col . '_id';
	}
	$select = $db->select()
			->from('elite_mapping', $cols);
	foreach ($rewriteLevels as $level)
	{
	    $select->group($level . '_id');
	}

	if(!is_null($productId))
	{
	    $select->where('entity_id = ?', $productId);
	}

	if ($perPage || $offset)
	{
	    $select->limit($perPage, $offset);
	}

	$result = $select->query(Zend_Db::FETCH_ASSOC);
	$return = array();
	while ($row = $result->fetch())
	{
	    array_push($return, $row);
	}

	return $return;
    }

    /** @return integer total # of definitions in the sitemap */
    function vehicleCount()
    {
	$col = 'count(distinct(CONCAT(';
	$colParams = array();
	foreach ($this->getSchema()->getRewriteLevels() as $level)
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

    protected function getSchema()
    {
	$schema = new Elite_Vaf_Model_Schema();
	$schema->setConfig($this->config);
	return $schema;
    }

}