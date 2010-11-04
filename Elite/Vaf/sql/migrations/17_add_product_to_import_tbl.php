<?php
class Vaf17
{
    function run()
    {
        $schema = new Elite_Vaf_Model_Schema();
        $db = Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();

        $db->query('ALTER TABLE `elite_import` ADD `sku` VARCHAR( 255 ) NOT NULL ,
        ADD `product_id` INT( 255 ) NOT NULL ');  
        
    }
}
Vaf17::run();

