<?php
$db = Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
$db->query("ALTER TABLE `elite_note` CHANGE `id` `code` VARCHAR( 50 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ");
$db->query("ALTER TABLE elite_note DROP PRIMARY KEY ");
$db->query("ALTER TABLE `elite_note` ADD UNIQUE (`code`)");
$db->query("ALTER TABLE `elite_note` ADD `id` INT( 50 ) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST ");