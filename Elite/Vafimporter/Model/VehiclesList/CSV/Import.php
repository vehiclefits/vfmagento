<?php
class Elite_Vafimporter_Model_VehiclesList_CSV_Import extends Elite_Vafimporter_Model
{
    /** @var array keyed by level name Ex. $count_added_by_level['make'] */
    protected $count_added_by_level = array();
    protected $start_count_added_by_level = array();
    protected $stop_count_added_by_level = array();
      
    /** @var integer */
    protected $skipped_definitions = 0;
    
    /** @var integer corresponds to the row # in the CSV we are reading in */
    protected $row_number = 1;
    
    /** Import the file */
    function import()
    {
        $this->getFieldPositions();
        $this->getReadAdapter()->beginTransaction();
        $this->cleanupTempTable();
        
        $this->resetCountAdded();
        $this->startCountingAdded();
        
        $this->getFieldPositions();
        while( $row = $this->getReader()->getRow() )
        {
            $values = $this->getLevelsArray( $row ); 
            $combinations = $this->getCombinations($values);
            foreach( $combinations as $combination )
            {
                $this->insertIntoTempTable($row,$combination);
            }
        }
        $this->insertLevelsFromTempTable();
        $this->getReader()->rewind();
        
        $this->getReader()->getRow(); // pop fields
        while( $row = $this->getReader()->getRow() )
        {
            $this->importRow($row);
        }
        $this->stopCountingAdded();
        
        $this->getReadAdapter()->commit();
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
        $this->logVehicleRecords();
        $this->cleanupTempTable();
    }
    
    function cleanupTempTable()
    {
        $this->query('DELETE FROM elite_import');
    }
    
    function extractLevelsFromImportTable($level)
    {
        if( $this->getSchema()->getRootLevel() == $level || $this->getSchema()->isGlobal($level))
        {
            $sql = sprintf('INSERT INTO elite_%1$s (title) SELECT DISTINCT %1$s FROM elite_import WHERE %1$s_id = 0',$level);
            $this->query($sql);
        }
        else
        {
            $sql = sprintf(
                'INSERT INTO `elite_%1$s` (`title`, `%2$s_id`) SELECT DISTINCT `%1$s`, `%2$s_id` FROM `elite_import` WHERE `%1$s_id` = 0',
                $level,
                $this->getSchema()->getPrevLevel($level)
            );
            $this->query($sql);
        }
    }
    
    function updateIdsInTempTable($level)
    {
        if( $this->getSchema()->getRootLevel() == $level || $this->getSchema()->isGlobal($level))
        {
            $this->query(sprintf('UPDATE elite_import i, elite_%1$s l SET i.%1$s_id = l.id WHERE l.title = i.%1$s',$level));
        }
        else
        {        
            $sql = sprintf(
                'UPDATE elite_import i, `elite_%1$s` l
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
    
    function logVehicleRecords()
    {
        $cols = $this->getSchema()->getLevels();
        foreach($cols as $i=>$col)
        {
            $cols[$i] = $this->getReadAdapter()->quoteIdentifier($col);
        }
        $result = $this->getReadAdapter()->query('SELECT DISTINCT ' . implode(',', $cols) . ' FROM elite_import');
        while($row = $result->fetch() )
        {
            $this->log('Vehicle added: ' . implode(' ',$row), Zend_Log::INFO );
        }
    }
    
    /** Import a row from the file */
    function importRow($row)
    {   
        $this->row_number++;
        /** @todo replace conditional with polymorphism */
        if('Elite_Vafimporter_Model_VehiclesList_CSV_Import' == get_class($this))
        {
            return;
        }
        $values = $this->getLevelsArray( $row ); 
        $combinations = $this->getCombinations($values);
        
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
    
    /** Reset # of added Make,Model,Year each to Zero */
    function resetCountAdded()
    {
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
        foreach($this->getSchema()->getLevels() as $level )
        {
            $select = $this->getReadAdapter()->select()
                ->from('elite_'.$level,'count(*)');
            $result = $select->query()->fetchColumn();
            $this->start_count_added_by_level[$level] = $result;
        }
    }
    
    /** Probe how many Make,Model,Year there are after the import */
    function stopCountingAdded()
    {
        foreach($this->getSchema()->getLevels() as $level )
        {
            $select = $this->getReadAdapter()->select()
                ->from('elite_'.$level,'count(*)');
            $result = $select->query()->fetchColumn();
            $this->stop_count_added_by_level[$level] = $result;
            $this->count_added_by_level[$level] = $this->stop_count_added_by_level[$level] - $this->start_count_added_by_level[$level];
        }
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
            }
            else
            {
                $levels[$level] = 'Base';
            }
        }
        return $levels;
    }
    
    function getCombinations( $values )
    {
        $values = $this->trimSpaces($values);
        
        foreach( $this->getSchema()->getLevels() as $level )
        {
            $values = $this->explodeRangesAndEnumerations($level,$values);
            if(false === $values)
            {
                return array();
            }
        }
        
        $combinations = $this->getPowerSetCombinations($values);
        $combinations = $this->explodeWildcardCombinations($combinations);
                    
        return $combinations;
    }
    
    function explodeRangesAndEnumerations($level, $values)
    {
        if( $this->isStartEndRange($values,$level) )
        {
            $values = $this->explodeRanges($values, $level);
        }
        else if( $this->isCommaList($values,$level))
        {
            $values[$level] = $this->convertValuesListToArray( $values[$level] );
        }
        else
        {
            $values[$level] = $this->convertValueToArray( $values[$level] );
        }
        
        return $values;
    }
    
    function trimSpaces($values)
    {
        foreach($values as $key => $value)
        {
            $values[$key] = trim($value);
        }
        return $values;
    }

    function getPowerSetCombinations($values)
    {
        $combiner = new Elite_Vafimporter_Model_ArrayCombiner();
        $combiner->setTraits($values);
        $combinations = $combiner->getCombinations();
        
        // put them back in correct order (root through leaf level)
        foreach($combinations as $key => $combination)
        {
            $combinations[$key] = array();
            foreach( $this->getSchema()->getLevels()  as $level )
            {
                $combinations[$key][$level] = $combination[$level];
            }
        }
        return $combinations;
    }
    
    function explodeWildcardCombinations($combinations)
    {
        $result = array();
        foreach($combinations as $key => $combination)
        {
            // blow out {{all}} tokens
            $valueExploder = new Elite_Vafimporter_Model_ValueExploder();
            $result = array_merge( $result, $valueExploder->explode($combination) );
        }
        return $result;
    }
    
    function isCommaList($values,$level)
    {
        return preg_match('#,#',$values[$level]);
    }
    
    function convertValueToArray( $val )
    {
        return array($val);
    }
    
    function convertValuesListToArray( $val )
    {
        return explode( ',', $val);
    }
    
    function isStartEndRange($values,$level)
    {
        if(isset($values[$level.'_range']))
        {
            return true;
        }
        return isset($values[$level.'_start']) && isset($values[$level.'_end']);
    }
    
    function explodeRanges($values,$level)
    {
        if( isset($values[$level.'_range']))
        {
            $val = $values[$level.'_range'];
            $range = new Ne8Vehicle_Year_Range($val);
            if( !$range->isValid() )
            {
                $this->log('Line(' . $this->row_number . ') Invalid Year Range: [' . $val . ']', Zend_Log::NOTICE);
                return false;
            }
            $start = $range->start();
            $end = $range->end();
        }
        else
        {
            $start_value = $values[$level.'_start'];
            $end_value = $values[$level.'_end'];
            
            $startYear = new Ne8Vehicle_Year($start_value);
            if($startYear->isValid())
            {
                $start = $startYear->value();
            }
            else
            {
                $start = null;
            }
            
            $endYear = new Ne8Vehicle_Year($end_value);
            if($endYear->isValid())
            {
                $end = $endYear->value();
            }
            else
            {
                $end = null;
            }
        }
        
        if( $start > $end )
        {
            $newStart = $start;
            $newEnd = $end;
            
            $start = $newEnd;
            $end = $newStart;
        }
        
        if( $start && !$end )
        {
            $end = $start;
        }
        
        if( !$start && $end )
        {
            $start = $end;
        }

        for( $currentValue = $start; $currentValue <= $end; $currentValue++ )
        {
            $values[$level][] = $currentValue;
        }
        unset($values[$level.'_start']);
        unset($values[$level.'_end']);
        unset($values[$level.'_range']);
        return $values;
    }
    
    function getSchema()
    {
        $schema = new Elite_Vaf_Model_Schema();
        $schema->setConfig( $this->getConfig() );
        return $schema;
    }
    
}