<?php
class Elite_Vafnote_Model_ExportTest extends Elite_Vaf_TestCase
{
	function testExport()
	{
		$finder = new Elite_Vafnote_Model_Finder();
		$noteId = $finder->insert('code1','message1');
		
		$export = new Elite_Vafnote_Model_Export;
		$csv = $export->export();
		
		$expected = '"id","code","message"
"' . $noteId . '","code1","message1"
';

		$this->assertEquals( $expected, $csv );
	}
}