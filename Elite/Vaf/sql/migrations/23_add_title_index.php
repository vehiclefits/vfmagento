<?php
class Vaf23
{
    function run()
    {
        $schema = new VF_Schema();
        $db = Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
        foreach($schema->getLevels() as $level)
        {
            $db->query('ALTER TABLE `elite_level_' . str_replace(' ','_',$level) . '` ADD INDEX ( `title` )   ');
        }
    }
}
Vaf23::run();