<?php
class Vaf21
{
    function run()
    {
        $schema = new VF_Schema();
        $db = Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();

        $db->query('ALTER TABLE `elite_mapping` ADD `price` FLOAT NOT NULL  ');
        $db->query('ALTER TABLE `elite_import` ADD `price` FLOAT NOT NULL  ');
    }
}
Vaf21::run();