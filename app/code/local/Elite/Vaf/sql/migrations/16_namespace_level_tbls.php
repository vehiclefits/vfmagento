<?php
class Vaf16
{
    function run()
    {
        $schema = new VF_Schema();
        $db = Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();

        foreach( $schema->getLevels() as $level )
        {
            $old = 'elite_' . $level;
            $new = 'elite_level_' . $level;
            $db->query(sprintf("RENAME TABLE %s TO %s", $old, $new));  
        }
        
    }
}
Vaf16::run();