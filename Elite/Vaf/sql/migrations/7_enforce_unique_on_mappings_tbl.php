<?php
class Vaf7_enforce_unique_on_mappings_tbl
{
    function addUniqueOnMappings()
    {
        $schema = new Elite_Vaf_Model_Schema();
        $db = Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();

        $levels = array();
        foreach( $schema->getLevels() as $level )
        {
            $levels[] = sprintf( '`%s_id`', $level );
        }
        $levels[] = 'universal';
        $levels[] = 'entity_id';
        $levels = implode( ',', $levels );
        $query = "ALTER TABLE `elite_mapping` ADD UNIQUE ( %s );";
        $db->query( sprintf( $query, $levels ) );
    }
}
Vaf7_enforce_unique_on_mappings_tbl::addUniqueOnMappings();
