<?php
require_once('config.php');

// DO NOT EDIT BELOW HERE

Mage::app('admin')->setUseSessionInUrl(false);
Mage::getConfig()->init();

$file = 'fitments-import.csv';
$import = new Elite_Vafdiagram_Model_ProductFitments_CSV_Import($file);
$import->import();