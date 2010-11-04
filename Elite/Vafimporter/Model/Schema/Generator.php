<?php
class Elite_Vafimporter_Model_Schema_Generator extends Ne8Vehicle_Schema_Generator
{
    function generator($levels)
    {
        $this->levels = $levels;
        $query = $this->createImportTable();
        return $query;        
    }
    
    function createImportTable()
    {
        $query = 'CREATE TABLE elite_import (';
            foreach($this->levels() as $level)
            {
                $query .= sprintf("`%s` VARCHAR(255) NOT NULL,", $level);
                $query .= sprintf("`%s_id` INTEGER(50) NOT NULL,", $level);
            }
            $query .= ' `sku` varchar(255) NOT NULL,';
            $query .= '`product_id` int(255) NOT NULL';
        $query .= ') ENGINE = InnoDb;';
        return $query;
    }
    
    function indexImportTable()
    {
        $levels = array();
        foreach( $this->levels() as $level )
        {
            $levels[] = sprintf( '`%s_id`', $level );
        }
        $levels = implode( ',', $levels );
        return sprintf("ALTER TABLE `elite_import` ADD INDEX (%s);",$levels);
    }
    
    function getSchema()
    {
        return new Elite_Vaf_Model_Schema();
    }
}