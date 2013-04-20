<?php
class Elite_Vafnote_Model_FinderTests_UpdateTest extends Elite_Vaf_TestCase
{
	function testShouldUpdate()
	{
		$noteId = $this->noteFinder()->insert('code','message');
		$this->noteFinder()->update($noteId,'new message');
		$note = $this->noteFinder()->findByCode('code');
		$this->assertEquals( 'new message', $note->message, 'should update a note' );
	}
	
	
}