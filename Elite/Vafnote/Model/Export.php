<?php
class Elite_Vafnote_Model_Export
{
	function export()
	{
		$finder = new Elite_Vafnote_Model_Finder();
		
		$result = '"id","code","message"';
		$result .= "\n";
		foreach( $finder->getNotes() as $note )
		{
			$result .= '"' . $note->id . '"';
			$result .= ',';
			$result .= '"' . $note->code . '"';
			$result .= ',';
			$result .= '"' . $note->message . '"';
			$result .= "\n";
		}
		return $result;
	}
}