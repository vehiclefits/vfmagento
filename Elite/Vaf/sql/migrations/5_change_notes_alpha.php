<?php
$db = Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();

if( file_exists(ELITE_PATH.'/Vafnote') )
{
    $query = "alter table elite_note change `id` `id` varchar(50) NOT NULL;";
    $db->query( $query );
}