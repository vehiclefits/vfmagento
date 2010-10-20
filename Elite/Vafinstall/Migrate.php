<?php
include(dirname(__FILE__).'/MigrateBase.php');
class Elite_Vafinstall_Migrate extends Shuffler_Db_Refactor
{
    /**
    * @return integer
    */
    function getCurrentVersion()
    {
        $tables = $this->getTables();
        
        $currentVersion = 0;
        if( in_array( 'elite_version', $tables ) )
        {
            $r = $this->db()->query("SELECT `version` FROM `elite_version` LIMIT 1 " );
            $currentVersion = $r->fetchColumn();
        }
        return (int)$currentVersion;
    }
    
    /**
    * @return array
    */
    protected function getTables()
    {
        $result = $this->db()->query('SHOW TABLES');
        $tables = array();
        foreach( $result->fetchAll( Zend_Db::FETCH_NUM ) as $row )
        {
            array_push( $tables, $row[0] );
        }
        return $tables;
    }
    
    protected function createVersionTable()
    {
        // create version
        $this->db()->query( " CREATE TABLE `elite_version` (
            `version` INT( 5 ) NOT NULL
        ) ENGINE=InnoDb");     
        $this->db()->query( " INSERT INTO `elite_version` ( `version` ) VALUES ( 0 ) " ); 
    }
    
    function pathToScripts()
    {
         return ELITE_PATH . '/Vaf/sql/migrations/';
    }
    
    
}