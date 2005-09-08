<?php
class Vaf24
{
    function run()
    {
        $schema = new Elite_Vaf_Model_Schema();
        $db = Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
        foreach($schema->getLevels() as $level)
        {
            $db->query('ALTER TABLE `elite_product_wheel` ADD `offset` FLOAT NOT NULL ');
            $db->query('ALTER TABLE `elite_definition_wheel` ADD `offset` FLOAT NOT NULL ');
        }
    }
}
Vaf24::run();