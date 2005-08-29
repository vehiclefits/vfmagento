<?php
require_once('config.php');

$stream = $stream = fopen("php://output", 'w');
$exporter = new Elite_Vafimporter_Model_VehiclesList_CSV_Export();
$exporter->export($stream);
