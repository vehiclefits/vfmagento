<?php
require_once('config.php');

// DO NOT EDIT BELOW HERE

$db = Zend_Db::factory('pdo_mysql', $params);
$db->getConnection();
Zend_Registry::set('db',$db);


$file = 'vehicles-list-import.xml';

$importer = new Elite_Vafimporter_Model_VehiclesList_XML_Import($file);

$importer->import();