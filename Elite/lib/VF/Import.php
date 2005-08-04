<?php

abstract class VF_Import extends VF_Import_Abstract implements VF_Configurable
{
    const E_WARNING = 1;

    protected $count = 0;
    /** @var Zend_Config */
    protected $config;

    abstract function import();

    function doImport()
    {
	$this->insertRowsIntoTempTable();
	$this->insertLevelsFromTempTable();
	$this->insertFitmentsFromTempTable();
	$this->insertVehicleRecords();
	$this->cleanupTempTable();

	$this->runDeprecatedImports();
    }

    function runDeprecatedImports()
    {
	
    }

    function cleanupTempTable()
    {
	$this->query('DELETE FROM elite_import');
    }

    function insertLevelsFromTempTable()
    {
	foreach ($this->getSchema()->getLevels() as $level)
	{
	    $this->updateIdsInTempTable($level);
	    $this->extractLevelsFromImportTable($level);
	    $this->updateIdsInTempTable($level);
	}
    }

    function extractLevelsFromImportTable($level)
    {
	if (!$this->getSchema()->hasParent($level))
	{
	    $sql = sprintf('INSERT INTO '.$this->schema()->levelTable($level) .' (title) SELECT DISTINCT %1$s FROM elite_import WHERE universal != 1 && %1$s_id = 0', str_replace(' ', '_', $level));
	    $this->query($sql);
	} else
	{
	    $sql = sprintf(
			    'INSERT INTO `'.$this->getSchema()->levelTable($level).'` (`title`, `%2$s_id`) SELECT DISTINCT `%1$s`, `%2$s_id` FROM `elite_import` WHERE universal != 1 && `%1$s_id` = 0',
			    str_replace(' ', '_', $level ),
			    str_replace(' ', '_', $this->getSchema()->getPrevLevel($level))
	    );
	    $this->query($sql);
	}
    }

    function updateIdsInTempTable($level)
    {
	if (!$this->getSchema()->hasParent($level))
	{
	    $this->query(sprintf('UPDATE elite_import i, elite_level_%2$d_%1$s l SET i.%1$s_id = l.id WHERE l.title = i.%1$s', str_replace(' ', '_', $level), $this->schema()->id()));
	} else
	{
	    $sql = sprintf(
			    'UPDATE elite_import i, `'.$this->getSchema()->levelTable($level).'` l
                SET i.`%1$s_id` = l.id
                WHERE i.`%1$s` = l.title AND i.`%2$s_id` = l.`%2$s_id`',
			    str_replace(' ', '_', $level),
			    str_replace(' ', '_', $this->getSchema()->getPrevLevel($level))
	    );
	    $this->query($sql);
	}
    }

    function insertVehicleRecords()
    {
	$cols = $this->getSchema()->getLevels();
	foreach ($cols as $i => $col)
	{
	    $cols[$i] = $this->getReadAdapter()->quoteIdentifier(str_replace(' ','_',$col) . '_id');
	}
	$query = 'REPLACE INTO '.$this->getSchema()->definitionTable().' (' . implode(',', $cols) . ')';
	$query .= ' SELECT DISTINCT ' . implode(',', $cols) . ' FROM elite_import WHERE universal != 1';
	$this->query($query);
    }

    function columns($row)
    {
        $newRow = array();
        foreach($row as $key=>$value)
        {
            $newRow[str_replace(' ','_',$key)] = $value;
        }
        return $newRow;
    }

    function insertFitmentsFromTempTable()
    {
	
    }

    /** @return array Field positions keyed by the field's names */
    function getFieldPositions()
    {
	parent::getFieldPositions();
	if (false == $this->fieldPositions)
	{
	    throw new VF_Import_VehiclesList_CSV_Exception_FieldHeaders('Field headers missing');
	}
	
	foreach ($this->schema()->getLevels() as $level)
	{
	    if (!$this->allowMissingFields() &&
		    !isset($this->fieldPositions[$level]) && (
		    !isset($this->fieldPositions[$level . '_start']) && !isset($this->fieldPositions[$level . '_end']) ) &&
		    !isset($this->fieldPositions[$level . '_range'])
	    )
	    {
		throw new VF_Import_VehiclesList_CSV_Exception_FieldHeaders('Unable to locate field header for [' . $level . '], perhaps not using comma delimiter' . print_r($this->fieldPositions,1));
	    }
	}
	return $this->fieldPositions;
    }

    function allowMissingFields()
    {
	return $this->getConfig()->importer->allowMissingFields;
    }

    function getConfig()
    {
	if (!$this->config instanceof Zend_Config)
	{
	    $this->config = Elite_Vaf_Helper_Data::getInstance()->getConfig();
	}
	return $this->config;
    }

    function setConfig(Zend_Config $config)
    {
	$this->config = $config;
    }

}
