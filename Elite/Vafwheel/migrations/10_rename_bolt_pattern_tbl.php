<?php
$db = Elite_Vaf_Helper_Data::getInstance()->getReadAdapter(); 
$query = "RENAME TABLE elite_Fitment_bolt_pattern to elite_definition_wheel;";
$db->query( $query );

$query = "alter table elite_definition_wheel change `Fitment_id` leaf_id int(50) NOT NULL;";
$db->query( $query );