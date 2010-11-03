<?php
require_once('config.php');

$file = 'product-fitments-export.csv';
$exporter = new Elite_Vafimporter_Model_ProductFitments_CSV_Export();
file_put_contents($file, $exporter->export());