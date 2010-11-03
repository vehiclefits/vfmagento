<?php
require_once('config.php');

$file = 'vehicles-list-import.csv';

$writer = new Zend_Log_Writer_Stream('vehicles-list-import.csv.log');
$log = new Zend_Log($writer);

$importer = new Elite_Vafimporter_Model_VehiclesList_CSV_Import($file);
$importer->setLog($log);

$importer->import();