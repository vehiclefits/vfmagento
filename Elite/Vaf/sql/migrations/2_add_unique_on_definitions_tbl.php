<?php
class Vaf2_add_unique_on_definitions
{
	function addUniqueOnDefinitions()
	{
		$schema = new Elite_Vaf_Model_Schema();
		$db = Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();

		$levels = array();
		foreach( $schema->getLevels() as $level )
		{
			$levels[] = sprintf( '`%s_id`', $level );
		}
		$levels = implode( ',', $levels );
		$query = "ALTER TABLE `elite_definition` ADD UNIQUE ( %s );";
		$db->query( sprintf( $query, $levels ) );
	}
}
Vaf2_add_unique_on_definitions::addUniqueOnDefinitions();