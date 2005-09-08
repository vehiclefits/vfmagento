<?php
class Vaf25
{
    function run()
    {
        $schema = new Elite_Vaf_Model_Schema();
        $db = Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
        foreach($schema->getLevels() as $level)
        {
            $db->query('ALTER TABLE `elite_mapping` ADD INDEX ( `entity_id` ) ;');
        }
    }
}
Vaf25::run();