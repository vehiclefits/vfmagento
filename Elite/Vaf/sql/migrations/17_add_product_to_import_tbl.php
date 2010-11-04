<?php
class Vaf17
{
    function run()
    {
        $schema = new Elite_Vaf_Model_Schema();
        $db = Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();

        $db->query('ALTER TABLE `elite_import` ADD `sku` VARCHAR( 255 ) NULL ,
        ADD `product_id` INT( 255 ) NULL,
        ADD `universal` INT(1) NULL,
        ADD `existing` INT( 1 ) NOT NULL,
        ADD `id` INT( 255 ) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST,
        ADD `line` INT( 255 ) NOT NULL  ');  
        
    }
}
Vaf17::run();

