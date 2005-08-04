<?php
class VF_Import_ProductFitments_CSV_Import extends VF_Import_VehiclesList_CSV_Import
{
    /** @var array of sku strings that were skipped becuase they did not match any product */
    protected $skipped_skus = array(); 
    
    /** @var array of sku strings that were skipped becuase they did not match any product */
    protected $nonexistant_skus = array();
    
    protected $nonexistant_sku_row_count = 0;
    protected $nonexistant_sku_count = 0;
    
    /** @var integer number of mapping rows that were skipped because the mapping is already "known about" */
    protected $skipped_mappings = 0;
    protected $already_existing_mappings = 0;
    protected $invalid_vehicle_count = 0;
    
    /** @var integer */
    protected $added_mappings = 0;
    protected $start_count_mappings;
    protected $stop_count_mappings;
    
    protected $rows_with_invalid_sku = array();
    
    function doStartCountingAdded()
    {
        $select = $this->getReadAdapter()->select()->from($this->getSchema()->mappingsTable(),'count(*)');
        $result = $select->query()->fetchColumn();
        $this->start_count_mappings = $result;
    }
    
    function doStopCountingAdded()
    {
        $select = $this->getReadAdapter()->select()->from($this->getSchema()->mappingsTable(),'count(*)');
        $result = $select->query()->fetchColumn();
        $this->stop_count_mappings = $result;
    }
    
    function getSkippedSkus()
    {
        return $this->skipped_skus;
    }
    
    function nonExistantSkus()
    {
        return $this->nonexistant_skus;
    }
    
    function nonExistantSkusCount()
    {
        return $this->nonexistant_sku_count;
    }
    
    function rowsWithNonExistantSkus()
    {
        return $this->nonexistant_sku_row_count;
    }
    
    function getCountMappings()
    {
        return $this->stop_count_mappings - $this->start_count_mappings;
    }
    
    function getCountSkippedMappings()
    {
        return $this->skipped_mappings;
    }
    
    function invalidVehicleCount()
    {
        return $this->invalid_vehicle_count;
    }
    
    function doGetCombinations($combinations, $row)
    {
        $new_combinations = array();
        foreach($combinations as $combination)
        {
            foreach($this->skus($row) as $sku)
            {
                $combination['sku'] = $sku;
                $combination['universal'] = $this->getFieldValue('universal', $row);
                array_push($new_combinations, $combination);
            }
        }
        
        return $new_combinations;
    }
    
    function insertFitmentsFromTempTable()
    {
        $this->updateProductIdsInTempTable();
        $this->determineInvalidSkus();
        $this->determineAlreadyExistingFitments();
        $this->extractFitmentsFromImportTable();
        $this->updateMappingIdsInTempTable();
        $this->extractNotesFromImportTable();
    }
    
    function updateProductIdsInTempTable()
    {
        $this->query('UPDATE elite_import i, ' . $this->getProductTable() . ' p
                      SET i.product_id = p.entity_id
                      WHERE i.sku = p.sku');
    }
    
    function determineInvalidSkus()
    {
        $select = 'SELECT count(`sku`) FROM elite_import WHERE `sku` NOT IN (select `sku` from '. $this->getProductTable() . ')';
        $this->nonexistant_sku_count = $this->getReadAdapter()->query($select)->fetchColumn();
        
        $select = 'SELECT DISTINCT(`sku`) FROM elite_import WHERE `sku` NOT IN (select `sku` from '. $this->getProductTable() . ') LIMIT 10';
        foreach( $this->getReadAdapter()->query($select)->fetchAll() as $row )
        {
            array_push($this->nonexistant_skus, $row['sku']);
        }
        
        $select = 'SELECT `sku`, `line` FROM elite_import WHERE `sku` NOT IN (select `sku` from '. $this->getProductTable() . ') GROUP BY `line`';
        foreach( $this->getReadAdapter()->query($select)->fetchAll() as $row )
        {
            $this->log('Line(' . $row['line'] . ') Non Existant SKU \'' . $row['sku'] . '\'', Zend_Log::NOTICE );
        }
        
        $select = 'SELECT COUNT(DISTINCT(`line`)) FROM elite_import WHERE `sku` NOT IN (select `sku` from '. $this->getProductTable() . ')';
        $this->nonexistant_sku_row_count = $this->getReadAdapter()->query($select)->fetchColumn();
    }
    
    function determineAlreadyExistingFitments()
    {
        $condition = '';
        foreach($this->schema()->getLevels() as $level)
        {
            $condition .= 'i.' . $level . '_id = m.' . $level . '_id';
            if($this->schema()->getLeafLevel() != $level )
            {
                $condition .= ' && ';
            }
        }
        
        $select = $this->getReadAdapter()->select()
            ->from(array('i'=>'elite_import'), 'count(*)')
            ->joinLeft(array('m'=>$this->schema()->mappingsTable()), $condition, array())
            ->where('i.product_id = m.entity_id');
        $this->skipped_mappings = $this->getReadAdapter()->query($select)->fetchColumn();
    }
    
    function updateMappingIdsInTempTable()
    {
        $condition = '';
        foreach($this->schema()->getLevels() as $level)
        {
            $condition .= 'i.' . $level . '_id = m.' . $level . '_id';
            if($this->schema()->getLeafLevel() != $level )
            {
                $condition .= ' && ';
            }
        }
        
        $this->query('UPDATE elite_import i, '.$this->schema()->mappingsTable().' m
                      SET i.mapping_id = m.id
                      WHERE ' . $condition . ' && i.product_id = m.entity_id');
    }
    
    function extractFitmentsFromImportTable()
    {
	$cols = $this->cols();
        $sql = 'INSERT IGNORE INTO '.$this->getSchema()->mappingsTable().' (' . $this->cols() . ' universal, entity_id, price) SELECT ' . $this->cols() . ' universal, product_id, price from elite_import where product_id != 0';
        $this->query($sql);
    }
    
    function extractNotesFromImportTable()
    {
        $sql = 'SELECT * from elite_import where mapping_id != 0';
        foreach( $this->query($sql)->fetchAll() as $row )
        {
            $this->dispatchMappingImportEvent($row);
        }
    }
    
    function cols()
    {
        $cols = '';
        foreach($this->getSchema()->getLevels() as $level)
        {
            $cols .= $level . '_id, ';
        }
        return $cols;
    }
    
    /**
    * @return array of all possible SKUs, exploded by wild card, enumerated by comma, any combination therein
    */
    function skus($row)
    {
        $skuText = $row[ $this->getFieldPosition('sku') ];
        if( false === strpos($skuText,'*') && false === strpos($skuText,','))
        {
            return array($skuText);
        }
        
        $skus = $this->explodeSkusByComma($skuText);        
        $skus = $this->explodeSkusByWildcard($skus);        
        return $skus;
    }
    
    /**
    * Inputs a string, explodes by comma, or returns a single item array
    * 
    * @param string $skuText
    * @return array exploded SKUs
    */
    function explodeSkusByComma($skuText)
    {
        if( false !== strpos( $skuText,','))
        {
            return explode(',',$skuText);
        }
        return array($skuText);
    }
    
    /**
    * Inputs an array of SKUs, derives all possible SKUs with wildcards
    * 
    * @param array $skus
    * @return array of derived SKUs
    */
    function explodeSkusByWildcard($skus)
    {
        $return = array();
        
        foreach($skus as $sku)
        {
            $sku = str_replace('*','%', $sku);
            $result = $this->getReadAdapter()->select()
                ->from($this->getProductTable())
                ->where('sku LIKE ?', $sku)
                ->query();
            
            foreach( $result->fetchAll() as $matchedSku )
            {
                array_push($return, $matchedSku['sku']);
            }
        }
        return $return;
    }
    
    function makeNoteOfInvalidSku( $row )
    {
        $this->skipped_mappings++;
        $sku = $this->sku($row);
        
        $this->nonexistant_sku_count++;
        if(!in_array($sku, $this->nonexistant_skus))
        {
            array_push( $this->nonexistant_skus, $sku );
            $this->log('Line(' . $this->row_number . ') Non Existant SKU \'' . $sku . '\'', Zend_Log::NOTICE);
        }
    }
    
    function sku($row)
    {
        return $row[ $this->getFieldPosition('sku') ];    
    }
    
    function isUniversal($row)
    {
        $isUniversal = false;
        if( $position = $this->getFieldPosition('universal') )
        {
            $isUniversal = isset($row[$position]) ? $row[$position] : 0;
        }
        return $isUniversal;
    }
    
    private static function getColumns( VF_Schema $schema )
    {
        $columns = '';
        
        $levels = $schema->getLevels(); 
        
        $c = count( $levels );
        $i = 0;
        foreach( $levels as $level )
        {
            $i++;
            
            $columns .= sprintf( '`%1$s_id`', $level );
            if( $i < $c )
            {
                $columns .= ',';
            }
        }
        return $columns;
    }
    
    /** @param VF_Vehicle */
    private static function getValues( $vehicle, VF_Schema $schema )
    {
        $values = '';
        
        $levels = $schema->getLevels();
        
        $values = '';
        $c = count( $levels );
        $i = 0;
        foreach( $levels as $level )
        {
            $i++;
            
            $values .= $vehicle->getLevel($level)->getId();
            if( $i < $c )
            {
                $values .= ',';
            }
        }
        return $values;
    }

    function dispatchMappingImportEvent( $row )
    {
        if( file_exists( ELITE_PATH  . '/Vafnote/Observer/Importer/Mappings.php' ) )
        {
            $noteImporter = new Elite_Vafnote_Observer_Importer_Mappings;
            $noteImporter->doImportRow( $this->getFieldPositions(), $row );
        }

    }
    
    /** @return array Field positions keyed by the field's names */
    function getFieldPositions()
    {
        $this->fieldPositions = parent::getFieldPositions();
        if( !isset($this->fieldPositions['sku']) )
        {
            throw new VF_Import_VehiclesList_CSV_Exception_FieldHeaders('Unable to locate field header for [sku], perhaps not using comma delimiter');
        }
        return $this->fieldPositions;
    }
    
}
