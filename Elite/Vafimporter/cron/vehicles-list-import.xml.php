<?php
require_once('config.php');


$file = 'vehicles-list-import.xml';

$importer = new Elite_Vafimporter_Model_VehiclesList_XML_Import($file);

$importer->import();