<?php
require_once('config.php');

// DO NOT EDIT BELOW HERE

Mage::app('admin')->setUseSessionInUrl(false);
Mage::getConfig()->init();

$db = Zend_Db::factory('pdo_mysql', $params);
$db->getConnection();
Zend_Registry::set('db',$db);

$file = 'product-service-codes.csv';
$import = new ProductServiceCodeImporter($file);
$import->import();