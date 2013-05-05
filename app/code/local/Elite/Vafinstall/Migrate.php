<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to sales@vehiclefits.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Elite_Vafinstall_Migrate extends Elite_Vafinstall_MigrateBase
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