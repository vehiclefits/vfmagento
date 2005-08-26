<?php
class VF_Select extends Zend_Db_Select
{
    function addLevelTitles($fromTable='elite_mapping', $levels=array())
    {   
        if(array() == $levels)
        {
            $levels = $this->getSchema()->getLevels();
        }
        foreach($levels as $level )
        {
            $level = str_replace(' ', '_', $level);
            $table = 'elite_level_'.$level;
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