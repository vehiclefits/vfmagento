<?php
$db = Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();

if( file_exists(ELITE_PATH.'/Vafpaint') )
{
    $query = "RENAME TABLE elite_year_paint to elite_mapping_paint;";
    $db->query( $query );


    $query = "alter table elite_mapping_paint change `year_id` `mapping_id` varchar(50) NOT NULL;";
    $db->query( $query );
}