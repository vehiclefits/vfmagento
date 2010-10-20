<?php
require_once('config.php');

// DO NOT EDIT BELOW HERE

$db = Zend_Db::factory('pdo_mysql', $params);
$db->getConnection();
Zend_Registry::set('db',$db);


$file = 'vehicles-list-export.csv';
$exporter = new Elite_Vafimporter_Model_VehiclesList_CSV_Export();
file_put_contents($file, $exporter->export());
