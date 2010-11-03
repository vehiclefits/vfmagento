<?php
require_once('config.php');

$file = 'vehicles-list-export.csv';
$exporter = new Elite_Vafimporter_Model_VehiclesList_CSV_Export();
file_put_contents($file, $exporter->export());
