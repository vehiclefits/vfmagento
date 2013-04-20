<?php
$db = Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
$db->query("ALTER TABLE `elite_product_tire` ADD `tire_type` INT( 1 ) NOT NULL");