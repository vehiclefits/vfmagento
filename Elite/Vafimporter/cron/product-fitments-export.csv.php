<?php
require_once('config.php');

$stream = fopen("php://output", 'w');
$exporter = new Elite_Vafimporter_Model_ProductFitments_CSV_Export();
$exporter->export($stream);