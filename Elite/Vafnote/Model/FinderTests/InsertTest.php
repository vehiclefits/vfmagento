<?php
class Elite_Vafnote_Model_FinderTests_InsertTest extends Elite_Vaf_TestCase
{
    function testShouldInsertCode()
    {
        $this->noteFinder()->insert('code',null);
        $note = $this->noteFinder()->findByCode('code');
        $this->assertEquals( null, $note->message, 'should insert note code' );
    }
    
    function testShouldInsertMessage()
    {
        $this->noteFinder()->insert('code','message');
        $note = $this->noteFinder()->findByCode('code');
        $this->assertEquals( 'message', $note->message, 'should insert note message' );
    }
    
    function testShouldGeneratesUniqueCodes()
    {
        $this->assertEquals( 'code-1', $this->noteFinder()->uniqueCode(), 'should generate unique codes' );
    }

    function testShouldGeneratesUniqueCodes2()
    {
        $code1 = $this->noteFinder()->uniqueCode();
        $this->noteFinder()->insert($code1,'test');
        $this->assertEquals( 'code-2', $this->noteFinder()->uniqueCode(), 'should generate unique codes' );
    }
    
    function testShouldAutoGenerateCodeIfOmittedOnInsert()
    {
        $auto_increment_id = $this->noteFinder()->insert(null,'message');
        $note = $this->noteFinder()->find($auto_increment_id);
        $this->assertEquals( 'code-1', $note->code, 'should auto generate code if omitted on insert' );
    }
    
    function testShouldUseExistingCodeForExistingMessages()
    {
        $auto_increment_id = $this->noteFinder()->insert('myCode','message');
        $noteId = $this->noteFinder()->insert(null,'message');
        $note = $this->noteFinder()->find($noteId);
        $this->assertEquals( 'myCode', $note->code, 'should use existing note code for existing note message' );
    }
    
    function testShouldInsertNoteRelationship()
    {
        $vehicle = $this->createMMY();
        $this->noteFinder()->insert('code',null);
        $product_id = $this->insertProduct('sku');
        $fitmentId = $this->insertMappingMMY($vehicle,$product_id);
        $this->noteFinder()->insertNoteRelationship( $fitmentId, 'code' );
        
        $this->assertEquals( 1, count($this->noteFinder()->getNotes($fitmentId)), 'should insert note relationship for a fitment' );
    }
}