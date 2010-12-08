<?php
class Elite_Vafimporter_Model_VehiclesList_Xml_Import extends Elite_Vafimporter_Model
{
    protected $file;
    
    function __construct( $file )
    {
        $this->file = $file;
    }
    
    function import()
    {
        $this->log('Import Started',Zend_Log::INFO);
        $this->getReadAdapter()->beginTransaction();
        
        try
        {
            $this->doImport();
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
    
    function insertRowsIntoTempTable()
    {
        $this->cleanupTempTable();
        
        $xmlDocument = simplexml_load_file($this->file);
        
        foreach( $xmlDocument->definition as $vehicleInput )
        {
        
            $this->row_number++;
            $values = $this->getLevelsArray( $vehicleInput ); 
            if(!$values)
            {
                continue;
            }
            
            $this->insertIntoTempTable($values);
        }
    }
    
    function insertIntoTempTable($values)
    {
        $combination['line'] = $this->row_number;
        foreach($this->getSchema()->getLevels() as $level)
        {
            $combination[$level] = $values[$level];
            $combination[$level.'_id'] = $values[$level.'_id'];
        }

        $this->getReadAdapter()->insert('elite_import',$combination);
    }
    
    function extractLevelsFromImportTable($level)
    {
        if( !$this->getSchema()->hasParent($level))
        {
            $sql = sprintf('INSERT INTO elite_level_%1$s (`id`, `title`) SELECT DISTINCT `%1$s_id`, `%1$s` FROM elite_import WHERE universal != 1',$level);
            $this->query($sql);
        }
        else
        {
            $sql = sprintf(
                'INSERT INTO `elite_level_%1$s` (`id`, `title`, `%2$s_id`) SELECT DISTINCT `%1$s_id`, `%1$s`, `%2$s_id` FROM `elite_import` WHERE universal != 1',
                $level,
                $this->getSchema()->getPrevLevel($level)
            );
            $this->query($sql);
        }
    }
    
    function getLevelsArray($vehicleInput)
    {
        $array = array();
        foreach($this->getSchema()->getLevels() as $level)
        {
            $array[$level] = (string)$vehicleInput->$level;
            $levelObj = $vehicleInput->$level;
            $array[$level . '_id'] = (string)$levelObj['id'];
        }
        return $array;
    }

    function getSchema()
    {
        return new Elite_Vaf_Model_Schema();
    }
}