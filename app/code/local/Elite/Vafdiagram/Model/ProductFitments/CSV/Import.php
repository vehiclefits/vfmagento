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

class Elite_Vafdiagram_Model_ProductFitments_CSV_Import extends VF_Import_ProductFitments_CSV_Import
{

    function __construct( $file )
    {
        $this->file = $file;
	$this->handle = fopen($file,'r');
    }

    function import()
    {
        $this->log('Import Started',Zend_Log::INFO);
        
        try
        {
            $this->getFieldPositions();
            $this->doImport();
        }
        catch(Exception $e)
        {
	    $this->log('Import Cancelled & Reverted Due To Critical Error: ' . $e->getMessage() . $e->getTraceAsString(), Zend_log::CRIT);
            throw $e;
        }

        $this->log('Import Completed',Zend_Log::INFO);
    }

    function doGetFieldPositions()
    {
	return fgetcsv($this->handle);
    }

    function doImport()
    {
	while ($this->current_row = fgetcsv($this->handle))
	{
	    $this->row_number++;
	    $this->log('service code started ' . $this->getFieldValue('service_code', $this->current_row),Zend_Log::INFO);
	    
	    
	    $this->getReadAdapter()->beginTransaction();
	    
	    $this->cleanupTempTable();
	    $this->startCountingAdded();
	    $this->insertRowsIntoTempTable();

	    $this->insertLevelsFromTempTable();
	    $this->insertFitmentsFromTempTable();
	    $this->insertVehicleRecords();

	    $this->stopCountingAdded();

	    $this->getReadAdapter()->commit();
	}
    }

    function insertRowsIntoTempTable()
    {
	$row = $this->current_row;
	
	$streamFile = sys_get_temp_dir() . '/vaf-import-' . md5(uniqid());
	$stream = fopen($streamFile, 'w');

	$values = $this->getLevelsArray($row);
	if (!$values)
	{
	    continue;
	}

	$combinations = $this->getCombinations($values, $row);

	foreach ($combinations as $combination)
	{
	    $serviceCode = $this->getFieldValue('service_code', $row);
	    foreach ($this->serviceCodeCombinations($combination, $serviceCode) as $serviceCodeCombination)
	    {
		$this->insertIntoTempStream($stream, $row, $serviceCodeCombination);
	    }
	}
	
	$this->importFromTempStream($streamFile);
    }

    function importFromTempStream($streamFile)
    {
	$this->getReadAdapter()->query('
	    LOAD DATA INFILE ' . $this->getReadAdapter()->quote($streamFile) . '
	    INTO TABLE elite_import
		FIELDS TERMINATED BY \',\'  ENCLOSED BY \'"\'
	    (' . $this->getSchema()->getLevelsString() . ',sku,universal,product_id,service_code)
	');
    }

    function updateProductIdsInTempTable()
    {

    }

    function insertVehicleRecords()
    {
	$cols = $this->getSchema()->getLevels();
	foreach ($cols as $i => $col)
	{
	    $cols[$i] = $this->getReadAdapter()->quoteIdentifier($col . '_id');
	}
	$cols[] = 'service_code';
	$query = 'REPLACE INTO ' . $this->getSchema()->definitionTable() . ' (' . implode(',', $cols) . ')';
	$query .= ' SELECT DISTINCT ' . implode(',', $cols) . ' FROM elite_import WHERE universal != 1';

	$this->query($query);
    }

    function serviceCodeCombinations($combination, $serviceCode)
    {
	$combinations = array();
	foreach ($this->products($serviceCode) as $product_id)
	{
	    $combinations[] = $combination + array(
		'product_id' => $product_id,
		'service_code' => $serviceCode,
	    );
	}
	return $combinations;
    }

    function products($serviceCode)
    {
	$rs = $this->getReadAdapter()->select()
			->from('elite_product_servicecode', array('product_id'))
			->where('elite_product_servicecode.service_code = ?', $serviceCode)
			->query();
	$products = array();
	foreach ($rs->fetchAll() as $row)
	{
	    $products[] = $row['product_id'];
	}
	return $products;
    }

//    function log($msg) { echo $msg."\n"; }

}