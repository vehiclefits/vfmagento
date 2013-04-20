<?php
$db = Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();

$db->query("
CREATE TABLE IF NOT EXISTS `elite_vehicle_tire` (
  `leaf_id` int(50) NOT NULL,
  `section_width` int(3) NOT NULL,
  `aspect_ratio` int(3) NOT NULL,
  `diameter` int(3) NOT NULL,
  `tire_type` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

$db->query("
ALTER TABLE `elite_vehicle_tire` ADD UNIQUE (
    `leaf_id` ,
    `section_width` ,
    `aspect_ratio` ,
    `diameter` ,
    `tire_type`
);");