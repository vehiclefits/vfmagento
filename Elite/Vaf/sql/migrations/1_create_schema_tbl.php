<?php
$db = Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();

$query = "CREATE TABLE `elite_schema` (
`key` VARCHAR( 25 ) NOT NULL ,
`value` VARCHAR( 255 ) NOT NULL
) ENGINE = InnoDB;";
$db->query( $query );

$schema = new VF_Schema();
$levels = $schema->getLevels();
if(!count($levels))
{
    $levels = array( 'make', 'model', 'year' );
}
foreach($levels as $level)
{
    if(!trim($level))
    {
        $levels = array( 'make', 'model', 'year' );
    }
}
$db->insert( 'elite_schema', array('key'=>'levels','value'=>implode(',',$levels)) );