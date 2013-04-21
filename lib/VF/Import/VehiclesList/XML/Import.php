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
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
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
        $levelTable = $this->getSchema()->levelTable($level);
        $sql = "INSERT INTO {$levelTable} (`id`, `title`) ";
        $sql .= "SELECT DISTINCT `{$level}_id`, `{$level}` ";
        $sql .= "FROM elite_import i WHERE universal != 1 ";
        $sql .= "ON DUPLICATE KEY UPDATE title=VALUES(title);)";
        $this->query($sql);
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