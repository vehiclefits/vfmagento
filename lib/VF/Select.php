<?php
class VF_Select extends Zend_Db_Select
{
    function addLevelTitles($fromTable=null, $levels=array())
    {   
        if(is_null($fromTable))
        {
            $fromTable = $this->getSchema()->mappingsTable();
        }
        
        if(array() == $levels)
        {
            $levels = $this->getSchema()->getLevels();
        }
        foreach($levels as $level )
        {
            $level = str_replace(' ', '_', $level);
            $table = 'elite_level_' . $this->getSchema()->id() . '_'.$level;
            $condition = "{$table}.id = {$fromTable}.{$level}_id";
            $this->joinLeft($table, $condition, array($level=>'title', $level.'_id'=>'id') );
        }
        return $this;
    }
    
    function whereLevelIdsEqual($levelIds)
    {
        foreach($levelIds as $level => $id)
        {
            $this->where($level . '_id = ?', $id);
        }
        return $this;
    }
    
    function getSchema()
    {
        return new VF_Schema();
    }
}