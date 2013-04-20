<?php
require_once('config.php');

// DO NOT EDIT BELOW HERE

Mage::app('admin')->setUseSessionInUrl(false);
Mage::getConfig()->init();

$file = 'product-service-codes.csv';
$import = new Elite_Vafdiagram_Model_ProductServiceCodeImporter($file);
$import->import();