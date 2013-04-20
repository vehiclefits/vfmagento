<?php
require_once('config.php');

$stream = $stream = fopen("php://output", 'w');
$exporter = new VF_Import_VehiclesList_CSV_Export();
$exporter->export($stream);
