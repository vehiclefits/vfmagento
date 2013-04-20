<?php
require_once('config.php');

$stream = fopen("php://output", 'w');
$exporter = new VF_Import_ProductFitments_CSV_Export();
$exporter->export($stream);