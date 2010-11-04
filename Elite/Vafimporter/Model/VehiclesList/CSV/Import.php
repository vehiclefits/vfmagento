<?php
class Elite_Vafimporter_Model_VehiclesList_CSV_Import extends Elite_Vafimporter_Model
{
    /** @var array keyed by level name Ex. $count_added_by_level['make'] */
    protected $count_added_by_level = array();
    protected $start_count_added_by_level = array();
    protected $stop_count_added_by_level = array();
    
    /** @var integer */
    protected $start_count_vehicles, $stop_count_vehicles;
      
    /** @var integer */
    protected $skipped_definitions = 0;
    
    /** @var integer corresponds to the row # in the CSV we are reading in */
    protected $row_number = 1;
    
    function import()
    {
        $this->log('Import Started',Zend_Log::INFO);
        $this->getReadAdapter()->beginTransaction();
        
        try
        {
            $this->startCountingAdded();
            $this->getFieldPositions();
            $this->doImport();
            $this->stopCountingAdded();
        }
        catch(Exception $e)
        {
            $this->getReadAdapter()->rollBack();
            $this->log('Import Cancelled & Reverted Due To Critical Error: ' . $e->getMessage() . $e->getTraceAsString(), Zend_log::CRIT);
            throw $e;
        }
        
        $this->getReadAdapter()->commit();
        $this->log('Import Completed',Zend_Log::INFO);
    }
    
    function doImport()
    {
        $this->insertRowsIntoTempTable();
        $this->insertLevelsFromTempTable();
        $this->runDeprecatedImports();
    }
    
    function insertRowsIntoTempTable()
    {
        $this->cleanupTempTable();
        while( $row = $this->getReader()->getRow() )
        {
            $values = $this->getLevelsArray( $row ); 
            $combinations = $this->getCombinations($values, $row);
            
            $this->row_number++;
            foreach( $combinations as $combination )
            {
                $this->insertIntoTempTable($row,$combination);
            }
        }
    }
    
    function runDeprecatedImports()
    {
        $this->getReader()->rewind();
        
        $this->getReader()->getRow(); // pop fields
        $this->row_number = 0;
        while( $row = $this->getReader()->getRow() )
        {
            $this->importRow($row);
        }
    }
    
    function insertIntoTempTable($row,$combination)
    {
        if($this->fieldsAreBlank($combination))
        {
            return;
        }
        
        $this->getReadAdapter()->insert('elite_import',$combination);
    }
    
    function insertLevelsFromTempTable()
    {
        foreach($this->getSchema()->getLevels() as $level)
        {
            $this->updateIdsInTempTable($level);
            $this->extractLevelsFromImportTable($level);
            $this->updateIdsInTempTable($level);
        }
        
        $this->insertVehicleRecords();
        $this->cleanupTempTable();
    }
    
    function cleanupTempTable()
    {
        $this->query('DELETE FROM elite_import');
    }
    
    function extractLevelsFromImportTable($level)
    {
        if( !$this->getSchema()->hasParent($level))
        {
            $sql = sprintf('INSERT INTO elite_level_%1$s (title) SELECT DISTINCT %1$s FROM elite_import WHERE %1$s_id = 0',$level);
            $this->query($sql);
        }
        else
        {
            $sql = sprintf(
                'INSERT INTO `elite_level_%1$s` (`title`, `%2$s_id`) SELECT DISTINCT `%1$s`, `%2$s_id` FROM `elite_import` WHERE `%1$s_id` = 0',
                $level,
                $this->getSchema()->getPrevLevel($level)
            );
            $this->query($sql);
        }
    }
    
    function updateIdsInTempTable($level)
    {
        if( !$this->getSchema()->hasParent($level) )
        {
            $this->query(sprintf('UPDATE elite_import i, elite_level_%1$s l SET i.%1$s_id = l.id WHERE l.title = i.%1$s',$level));
        }
        else
        {        
            $sql = sprintf(
                'UPDATE elite_import i, `elite_level_%1$s` l
                SET i.`%1$s_id` = l.id
                WHERE i.`%1$s` = l.title AND i.`%2$s_id` = l.`%2$s_id`',
                $level,
                $this->getSchema()->getPrevLevel($level)
            );
            $this->query($sql);
        }       
    }
    
    function insertVehicleRecords()
    {
        $cols = $this->getSchema()->getLevels();
        foreach($cols as $i=>$col)
        {
            $cols[$i] = $this->getReadAdapter()->quoteIdentifier($col.'_id');
        }
        
        $query = 'REPLACE INTO elite_definition (' . implode(',', $cols) . ')';
        $query .= ' SELECT DISTINCT ' . implode(',', $cols) . ' FROM elite_import';
        $this->query($query);
    }
    
    function importRow($row)
    {   
        $this->row_number++;
    }
    
    /** @deprecated */
    function oldImportRow($row)
    {
        $values = $this->getLevelsArray( $row ); 
        $combinations = $this->getCombinations($values, $row);
        
        foreach( $combinations as $combination )
        {
            if( $this->fieldsAreBlank($combination) )
            {
                $this->doImportRow($row,false);
                continue;
            }
            
            $vehicle = $this->vehicleFinder()->findOneByLevels($combination);
            $this->doImportRow($row,$vehicle);
        }
    }
    
    function vehicleFinder()
    {
        return new Elite_Vaf_Model_Vehicle_Finder($this->getSchema());
    }
    
    /** @return boolean true only if all field names in the combination are blank */
    function fieldsAreBlank($combination)
    {
        foreach($this->schema()->getLevels() as $level)
        {
            if($combination[$level]=='')
            {
                return true;
            }
        }
        return false;
    }
    
    /**
    * @param array $row
    * @param Elite_Vaf_Model_Vehicle|boolean the vehicle, false if none (for example, when setting a product as universal)
    */
    function doImportRow( $row, $vehicle )
    {
    }
    
    /** Reset # of added Vehicles, Makes, Years, etc. each to Zero */
    function resetCountAdded()
    {
        $this->start_count_vehicles = 0;
        $this->stop_count_vehicles = 0;
        
        $this->count_added_by_level = array();
        $this->start_count_added_by_level = array();
        $this->stop_count_added_by_level = array();
        foreach($this->getSchema()->getLevels() as $level )
        {
            $this->count_added_by_level[$level] = 0;
            $this->start_count_added_by_level[$level] = 0;
            $this->stop_count_added_by_level[$level] = 0;
        }
    }
    
    /** Probe how many Make,Model,Year there are before the import */
    function startCountingAdded()
    {
        $this->resetCountAdded();
        $this->startCountingAddedLevels();
        $this->startCountingAddedVehicles();
    }
    
    /** Probe how many Make,Model,Year there are before the import */
    function startCountingAddedLevels()
    {
        foreach($this->getSchema()->getLevels() as $level )
        {
            $select = $this->getReadAdapter()->select()->from('elite_level_'.$level,'count(*)');
            $result = $select->query()->fetchColumn();
            $this->start_count_added_by_level[$level] = $result;
        }
    }
    
    function startCountingAddedVehicles()
    {
        $select = $this->getReadAdapter()->select()->from('elite_definition','count(*)');
        $result = $select->query()->fetchColumn();
        $this->start_count_vehicles = $result;
    }
    
    /** Probe how many Make,Model,Year there are after the import */
    function stopCountingAdded()
    {
        $this->stopCountingAddedLevels();
        $this->stopCountingAddedVehicles();
    }
    
    function stopCountingAddedLevels()
    {
        foreach($this->getSchema()->getLevels() as $level )
        {
            $select = $this->getReadAdapter()->select()->from('elite_level_'.$level,'count(*)');
            $result = $select->query()->fetchColumn();
            $this->stop_count_added_by_level[$level] = $result;
            $this->count_added_by_level[$level] = $this->stop_count_added_by_level[$level] - $this->start_count_added_by_level[$level];
        }
    }
    
    function stopCountingAddedVehicles()
    {
        $select = $this->getReadAdapter()->select()->from('elite_definition','count(*)');
        $result = $select->query()->fetchColumn();
        $this->stop_count_vehicles = $result;
    }
    
    /**
    * @param string $level
    * @return integer number of [make,model,or year] values that have been added during this import
    */
    function getCountAddedByLevel( $level )
    {
        if( !isset( $this->count_added_by_level[ $level ] ) )
        {
            return 0;
        }
        return (int)$this->count_added_by_level[ $level ];
    }
    
    function getCountAddedVehicles()
    {
        return $this->stop_count_vehicles - $this->start_count_vehicles;
    }
    
    /** @return integer */
    function getCountSkippedDefinitions()
    {
        return $this->skipped_definitions;
    }
    
    /**
    * @var array $row from import file
    * @return array keyed by level names (make,model,year) or ranges (year_start,year_end)
    */
    function getLevelsArray( $row )
    {
        $fieldPositions = $this->getFieldPositions();
        $levels = array();
        foreach( $this->getSchema()->getLevels() as $level )
        {
            if( isset($fieldPositions[$level.'_start']) && isset($fieldPositions[$level.'_end']) )
            {
                $levels[$level.'_start'] = $this->getFieldValue( $level.'_start', $row );
                $levels[$level.'_end'] = $this->getFieldValue( $level.'_end', $row );
            }
            else if( isset($fieldPositions[$level.'_range']) )
            {
                $levels[$level.'_range'] = $this->getFieldValue( $level.'_range', $row );
            }
            elseif( isset($fieldPositions[$level]) )
            {
                $levels[$level] = $this->getFieldValue( $level, $row );
                if(!$levels[$level])
                {
                    $this->log('Line(' . $this->row_number . ') Blank ' . ucfirst($level), Zend_Log::NOTICE);
                }
            }
            else
            {
                $levels[$level] = 'Base';
            }
        }
        return $levels;
    }
    
    function getCombinations( $values, $row )
    {
        $combiner = new Elite_Vafimporter_Model_Combiner($this->getSchema(), $this->getConfig());
        $combinations = $combiner->getCombinations($values);
        if($combiner->getError())
        {
            $this->log( 'Line(' . $this->row_number . ') ' . $combiner->getError(), Zend_Log::NOTICE );
        }
        $combinations = $this->doGetCombinations($combinations, $row);
        return $combinations;
    }
    
    function doGetCombinations($combinations, $row)
    {
        return $combinations;
    }
    
    function getSchema()
    {
        $schema = new Elite_Vaf_Model_Schema();
        $schema->setConfig( $this->getConfig() );
        return $schema;
    }
    
}