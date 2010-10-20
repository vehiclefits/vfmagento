<?php
require_once('config.php');

// DO NOT EDIT BELOW HERE

Mage::app('admin')->setUseSessionInUrl(false);
Mage::getConfig()->init();

$db = Zend_Db::factory('pdo_mysql', $params);
$db->getConnection();
Zend_Registry::set('db',$db);

$file = 'product-tire-sizes-import.csv';
$import = new Elite_Vaftire_Model_Catalog_Product_Import($file);
$import->import();