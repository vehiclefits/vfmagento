<?php
class Elite_Vafinstall_PathEnumerator
{
	function paths()
	{
		$tasks = $this->tasks();

		$paths = array('.');

        foreach( $tasks as $eachTask )
		{
			array_push( $paths, dirname(realpath($eachTask[1])) );
		}
		return array_unique($paths);
	}
	
	function tasks()
	{
		$tasks = array(
		);

		return $tasks;
	}
}