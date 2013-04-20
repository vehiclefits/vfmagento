<?php
class Elite_Vafgarage_Model_Schema_Generator extends VF_Schema_Generator
{
    function generator($levels)
    {
        return '';
    }
    
    function install()
    {
        //$sql = "
//        ALTER TABLE `".$this->tablePrefix()."sales_flat_order_item` ADD `elite_vehicle` VARCHAR( 50 ) NOT NULL ;
//        ALTER TABLE `".$this->tablePrefix()."sales_flat_quote_item` ADD `elite_vehicle` VARCHAR( 50 ) NOT NULL ;
//        ";
        $sql = "
        ALTER TABLE `".$this->tablePrefix()."sales_flat_order` ADD `elite_fit` VARCHAR( 50 ) NOT NULL ;
        ";

        return $sql; 
    }
    
}
