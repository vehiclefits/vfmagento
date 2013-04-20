<?php
$db = Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();

if( file_exists(ELITE_PATH.'/Vafwheel') )
{
    $query = "RENAME TABLE elite_year_bolt_pattern to elite_mapping_bolt_pattern;";
    $db->query( $query );

    $query = "alter table elite_mapping_bolt_pattern change `year_id` mapping_id int(50) NOT NULL;";
    $db->query( $query );
}