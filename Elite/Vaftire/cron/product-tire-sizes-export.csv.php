<?php
require_once('config.php');

// DO NOT EDIT BELOW HERE

$db = Zend_Db::factory('pdo_mysql', $params);
$db->getConnection();
Zend_Registry::set('db',$db);


$file = 'product-tire-sizes-export.csv';
$exporter = new Elite_Vaftire_Model_Catalog_Product_Export();
file_put_contents($file,$exporter->export());