<?php
class Elite_Vaf_Select extends Zend_Db_Select
{
    function addLevelTitles($fromTable='elite_mapping')
    {   
        foreach($this->getSchema()->getLevels() as $level )
        {
            $table = 'elite_level_'.$level;
            $condition = $table.'.id = '.$fromTable.'.'.$level.'_id';
            $this->joinLeft($table, $condition, array($level=>'title', $level.'_id'=>'id') );
        }
        return $this;
    }
    
    function getSchema()
    {
        return new Elite_Vaf_Model_Schema();
    }
}