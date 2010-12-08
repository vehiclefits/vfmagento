<?php
class Vaf18
{
    function run()
    {
        $schema = new Elite_Vaf_Model_Schema();
        $db = Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();

        $db->query('ALTER TABLE `elite_import` CHANGE `universal` `universal` INT( 1 ) NULL DEFAULT \'0\'');  
        
    }
}
Vaf18::run();

