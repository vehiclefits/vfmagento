<?php

class VF_Import_ProductFitments_CSV_Export extends VF_Import_VehiclesList_CSV_Export
{

    /** @var VF_Schema */
    protected $schema;

    protected function cols()
    {
	$return = $this->col('sku');
	$return .= $this->col('universal');
	$return .= parent::cols();
	$return .= $this->doCols();
	return $return;
    }

    protected function rows($stream)
    {
	$rowResult = $this->rowResult();
	$i = 0;
	while($row = $rowResult->fetch(Zend_Db::FETCH_OBJ))
	{
	    $i++;
	    fwrite($stream,  $this->col($row->sku));
	    fwrite($stream,  $this->col($row->universal));
	    fwrite($stream,  $this->definitionCells($row));
	    fwrite($stream,  $this->doRow($row));
	    fwrite($stream,  "\n");
	}
    }

    protected function rowResult()
    {
	$this->getReadAdapter()->getConnection()->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
	$select = $this->getReadAdapter()->select()
			->from($this->schema()->mappingsTable(), array('id', 'universal'));
	foreach ($this->schema->getLevels() as $level)
	{
	    $levelTable = $this->schema()->levelTable($level);
	    $condition = sprintf('%s.id = '.$this->schema()->mappingsTable().'.%s_id', $levelTable, $level);
	    $select->joinLeft($levelTable, $condition, array($level => 'title'));
	}
	$select->joinLeft(array('p' => $this->getProductTable()), 'p.entity_id = '.$this->schema()->mappingsTable().'.entity_id', array('sku'));
	return $this->query($select);
    }

    protected function getProductTable()
    {
	$resource = new Mage_Catalog_Model_Resource_Eav_Mysql4_Product;
	$table = $resource->getTable('catalog/product');
	return $table;
    }

    private function doCols()
    {
	if (file_exists(ELITE_PATH . '/Vafnote/Observer/Exporter/Mappings.php'))
	{
	    $exporter = new Elite_Vafnote_Observer_Exporter_Mappings_CSV();
	    return $exporter->doCols();
	}
    }

    private function doRow($row)
    {
	if (file_exists(ELITE_PATH . '/Vafnote/Observer/Exporter/Mappings.php'))
	{
	    $exporter = new Elite_Vafnote_Observer_Exporter_Mappings_CSV;
	    return $exporter->doRow($row);
	}
    }

}
