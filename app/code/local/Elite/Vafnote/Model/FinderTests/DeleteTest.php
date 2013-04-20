<?php
class Elite_Vafnote_Model_FinderTests_DeleteTest extends Elite_Vaf_TestCase
{
	function testUpdateNote()
	{
		$noteId = $this->noteFinder()->insert('code','message');
		$this->noteFinder()->update('code','new message');
		$this->noteFinder()->delete($noteId);
		$this->assertFalse( $this->noteFinder()->find($noteId), 'should delete a note' );
	}
}