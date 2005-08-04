<?php
class VF_Import_VehiclesList_Xml_Import extends VF_Import
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
            $levelTable = $this->getSchema()->levelTable($level);
            $sql = "INSERT INTO {$levelTable} (`id`, `title`) ";
            $sql .= "SELECT DISTINCT `{$level}_id`, `{$level}` ";
            $sql .= "FROM elite_import i WHERE universal != 1 ";
            $sql .= "ON DUPLICATE KEY UPDATE title=VALUES(title);)";
            $this->query($sql);
        }
        else
        {
            $pevLevel = $this->getSchema()->getPrevLevel($level);
            $levelTable = $this->getSchema()->levelTable($level);
            $sql = "INSERT INTO `{$levelTable}` (`id`, `title`, `{$pevLevel}_id`)";
            $sql .= "SELECT DISTINCT `{$level}_id`, `{$level}`, `{$pevLevel}_id`";
            $sql .= "FROM `elite_import` i WHERE universal != 1 ";
            $sql .= "ON DUPLICATE KEY UPDATE title=VALUES(title);)";
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
        return new VF_Schema();
    }
}