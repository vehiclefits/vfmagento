<?php
require_once('config.php');

// DO NOT EDIT BELOW HERE

Mage::app('admin')->setUseSessionInUrl(false);
Mage::getConfig()->init();

$file = 'product-wheel-sizes-import.csv';
$import = new Elite_Vafwheel_Model_Catalog_Product_Import($file);
$import->import();