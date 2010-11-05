<?php
class Elite_Vafimporter_Model_ProductFitments_CSV_Import extends Elite_Vafimporter_Model_VehiclesList_CSV_Import
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
        $select = $this->getReadAdapter()->select()->from('elite_mapping','count(*)');
        $result = $select->query()->fetchColumn();
        $this->start_count_mappings = $result;
    }
    
    function doStopCountingAdded()
    {
        $select = $this->getReadAdapter()->select()->from('elite_mapping','count(*)');
        $result = $select->query()->fetchColumn();
        $this->stop_count_mappings = $result;
    }
    
    //function importRow($row)
//    {   
//        $this->row_number++;
//        $this->oldImportRow($row);
//    }
    
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
        
        $select = 'SELECT DISTINCT(`sku`) FROM elite_import WHERE `sku` NOT IN (select `sku` from '. $this->getProductTable() . ')';
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
            /** @todo MAJOR DEFECT */
            $condition .= 'i.make_id = m.make_id';
            if($this->schema()->getLeafLevel() != $level )
            {
                $condition .= ' && ';
            }
        }
        
        $select = $this->getReadAdapter()->select()
            ->from(array('m'=>'elite_mapping'), 'count(*)')
            ->joinLeft(array('i'=>'elite_import'), $condition, array());
        
        $this->skipped_mappings = $this->getReadAdapter()->query($select)->fetchColumn();
    }
    
    function updateMappingIdsInTempTable()
    {
        $condition = '';
        foreach($this->schema()->getLevels() as $level)
        {
            /** @todo MAJOR DEFECT */
            $condition .= 'i.make_id = m.make_id';
            if($this->schema()->getLeafLevel() != $level )
            {
                $condition .= ' && ';
            }
        }
        
        /** @todo MAJOR DEFECT - doesn't filter by product id' */
        $this->query('UPDATE elite_import i, elite_mapping m
                      SET i.mapping_id = m.id
                      WHERE ' . $condition);
    }
    
    function extractFitmentsFromImportTable()
    {
        $cols = $this->cols();
        $sql = 'INSERT IGNORE INTO elite_mapping (' . $this->cols() . ' universal, entity_id) SELECT ' . $this->cols() . ' universal, product_id from elite_import ';
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
    * @param array $row
    * @param Elite_Vaf_Model_Vehicle|boolean the vehicle, false if none (for example, when setting a product as universal)
    */
//    function doImportRow( $row, $vehicle )
//    {
//        foreach( $this->skus($row) as $sku)
//        {
//            $entity_id = $this->productId($sku);
//            $row[$this->getFieldPosition('sku')] = $sku;
//            
//            if( $entity_id == false )
//            {
//                $this->rows_with_invalid_sku[$this->row_number] = true;
//                $this->makeNoteOfInvalidSku($row);
//            }
//            
//            if( false === $vehicle )
//            {
//                return $this->insertMapping($row, false);
//            }
//            
//            $mapping_id = $this->insertMapping($row,$vehicle);
//            $row['id'] = $mapping_id;
//            $this->dispatchMappingImportEvent( $row, $vehicle );
//        }
//    }
    
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
    
    /**
    * @var integer entity_id of the product row
    * @var Elite_Vaf_Model_Vehicle to check for assocation with
    * @return boolean true only if the mapping between the product+definition exists
    */
    function hasMapping( $entity_id, Elite_Vaf_Model_Vehicle $vehicle )
    {
        $sql = sprintf(
            "SELECT count(*) FROM elite_mapping WHERE entity_id = %d AND %s = %d LIMIT 1",
            (int)$entity_id,
            $this->getReadAdapter()->quoteIdentifier( $this->getSchema()->getLeafLevel() . '_id' ),
            (int)$vehicle->getLeafValue()
        );
        $r = $this->query( $sql );
        return (bool) 0 != $r->fetchColumn();
    }
    
    /**
    * @var integer product id
    * @var mixed boolean false for universal, or Elite_Vaf_Model_Vehicle to create a mapping for
    */
    function insertMapping($row, $vehicle )
    {
        $sku = $this->sku($row);
        $productId = $this->productId($sku);
        if(!$productId)
        {
			$this->skipped_mappings++;
			return;
        }
        
        if( $this->isUniversal($row) )
        {
            $product = new Elite_Vaf_Model_Catalog_Product();
            $product->setId($productId);
            $product->setUniversal(1);
            return;
        }
        
        if(false === $vehicle)
        {
            $this->invalid_vehicle_count++;
            $this->skipped_mappings++;
            return;
        }
        
        $mapping = new Elite_Vaf_Model_Mapping($productId,$vehicle);
        
        if($this->hasMapping($productId,$vehicle))
        {
            $this->already_existing_mappings++;
            $this->skipped_mappings++;
            return $mapping->save();
        }
        
        $mapping_id = $mapping->save();
        if(!$mapping_id)
        {
            $this->skipped_mappings++;
        }
        else
        {
            $this->added_mappings++;
        }
        return $mapping_id;
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
    
    private static function getColumns( Elite_Vaf_Model_Schema $schema )
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
    
    /** @param Elite_Vaf_Model_Vehicle */
    private static function getValues( $vehicle, Elite_Vaf_Model_Schema $schema )
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
            throw new Elite_Vafimporter_Model_VehiclesList_CSV_Exception_FieldHeaders('Unable to locate field header for [sku], perhaps not using comma delimiter');
        }
        return $this->fieldPositions;
    }
    
}
