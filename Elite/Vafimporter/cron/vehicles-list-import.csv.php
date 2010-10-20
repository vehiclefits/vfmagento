<?php
require_once('config.php');

// DO NOT EDIT BELOW HERE

$db = Zend_Db::factory('pdo_mysql', $params);
$db->getConnection();
Zend_Registry::set('db',$db);


$file = 'vehicles-list-import.csv';

$writer = new Zend_Log_Writer_Stream('vehicles-list-import.csv.log');
$log = new Zend_Log($writer);

$importer = new Elite_Vafimporter_Model_VehiclesList_CSV_Import($file);
$importer->setLog($log);

$importer->import();