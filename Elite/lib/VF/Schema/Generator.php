<?php
abstract class VF_Schema_Generator
{
    public $levels = array();
    public $level_options = array();
    
    const NEWLINE = "\n";
    
    function __construct()
    {
    }
    
    function getLevel( $i )
    {
        $levels = $this->levels();
        $level = isset( $levels[ $i ] ) ? $levels[ $i ] : false;
        $level = str_replace(' ', '_', $level);
        return $level;
    }
    
    function leafLevel()
    {
        $levels = $this->levels();
        return $levels[ $this->levelCount() - 1 ];
    }
    
    function levelCount()
    {
        return count( $this->levels() );
    }
    
    function levels()
    {
        $this->levels = (array)$this->levels;
        $levels = array();
        foreach($this->levels as $key => $level )
        {
            if(is_array($level))
            {
                $levelString = $key;
                $this->level_options[$levelString] = $level;
            }
            else
            {
                $levelString = $level;
            }
            array_push($levels, $levelString);
        }
        return $levels;
    }
    
    function isGlobal($level)
    {
        return isset( $this->level_options[$level]['global'] ) && $this->level_options[$level]['global'];
    }
    
    function tablePrefix()
    {
        if(!method_exists('Mage', 'getConfig'))
        {
            return '';
        }
        return (string)Mage::getConfig()->getTablePrefix();
    }
    
    function query( $sql )
    {
        return $this->getReadAdapter()->query( $sql );
    }
    
    /** @return Zend_Db_Adapter_Abstract */
    function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }
}