<?php
class Elite_Vafpaint_Model_Schema_Generator extends Ne8Vehicle_Schema_Generator
{
    function generator()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `elite_mapping_paint` (
          `id` int(50) NOT NULL AUTO_INCREMENT,
          `mapping_id` int(50) NOT NULL,
          `code` varchar(50) NOT NULL,
          `name` varchar(50) NOT NULL,
          `color` varchar(50) NOT NULL,
          PRIMARY KEY (`id`),
          KEY `mapping_id` (`mapping_id`)
        ) ENGINE=InnoDb ;";
        return $sql;
    }
    
    function install()
    {
        $sql = "
        ALTER TABLE `".$this->tablePrefix()."sales_flat_order_item` ADD `elite_paint` INT( 25 ) NOT NULL ;
        ALTER TABLE `".$this->tablePrefix()."sales_flat_order_item` ADD `elite_paint_other` VARCHAR( 25 ) NOT NULL ;
		ALTER TABLE `".$this->tablePrefix()."sales_flat_quote_item` ADD `elite_paint` INT( 25 ) NOT NULL ;
		ALTER TABLE `".$this->tablePrefix()."sales_flat_quote_item` ADD `elite_paint_other` VARCHAR( 25 ) NOT NULL ;
        ";

        return $sql; 
    }
    
}