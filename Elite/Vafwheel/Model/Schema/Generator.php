<?php
class Elite_Vafwheel_Model_Schema_Generator extends VafVehicle_Schema_Generator
{
    function generator()
    {
        return 'CREATE TABLE IF NOT EXISTS `elite_definition_wheel` (
          `leaf_id` int(50) NOT NULL,
          `lug_count` int(1) NOT NULL,
          `bolt_distance` decimal(4,1) NOT NULL COMMENT \'bolt distance in mm\',
          PRIMARY KEY (`leaf_id`,`lug_count`,`bolt_distance`),
          KEY `leaf_id` (`leaf_id`)
        ) ENGINE=InnoDb CHARSET=utf8;
        ALTER TABLE `elite_definition_wheel` ADD `offset` FLOAT NOT NULL;
        
        
        CREATE TABLE IF NOT EXISTS `elite_product_wheel` (
          `entity_id` int(50) NOT NULL,
          `lug_count` int(1) NOT NULL,
          `bolt_distance` decimal(4,1) NOT NULL COMMENT \'bolt distance in mm\',
          PRIMARY KEY (`entity_id`,`lug_count`,`bolt_distance`),
          KEY `entity_id` (`entity_id`)
        ) ENGINE=InnoDB CHARSET=utf8;
        ALTER TABLE `elite_product_wheel` ADD `offset` FLOAT NOT NULL ;
        '; 
    }
}