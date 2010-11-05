<?php
class Elite_Vafnote_Observer_Importer_MappingsTests_ByMessageTest extends Elite_Vafnote_Observer_Importer_MappingsTests_TestCase
{    
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
 
    function testShouldIgnoreRowsWithCodeButNoMessage_WithoutComma()
    {        
        $this->insertProduct('sku1');
        $this->import('"year_start","year_end","Make","Model","Sku","notes","note_message"
1990,2009,"Acura","Integra","sku1",code1
');
        
        $fitId = $this->getFitIdForSku('sku1');
        $notes = $this->noteFinder()->getNotes( $fitId );
        $this->assertEquals( 0, count($notes));
    }
     
    function testShouldIgnoreRowsWithCodeButNoMessage_WithComma()
    {        
        $this->insertProduct('sku1');
        $this->import('"year_start","year_end","Make","Model","Sku","notes","note_message"
1990,2009,"Acura","Integra","sku1",code1,
');
        
        $fitId = $this->getFitIdForSku('sku1');
        $notes = $this->noteFinder()->getNotes( $fitId );
        $this->assertEquals( 0, count($notes), 'should ignore rows with blank messages');
    }
       
    function testShouldAddNoteByMessage()
    {        
        $this->insertProduct('sku');
        $this->import('sku, make, model, year, note_message' . "\n" .
                      'sku, honda, civic, 2000, "This is my message"');
        
        $fitId = $this->getFitIdForSku('sku');
        $notes = $this->noteFinder()->getNotes( $fitId );
        $this->assertEquals( 'This is my message', $notes[0]->message );
    }
    
    function testShouldGenerateUniqueCodeForNewMessages()
    {        
        $this->insertProduct('sku');
        $this->import('sku, make, model, year, note_message' . "\n" .
                      'sku, honda, civic, 2000, "This is my message"');
        
        $fitId = $this->getFitIdForSku('sku');
        $notes = $this->noteFinder()->getNotes( $fitId );
        $this->assertEquals( 'code-1', $notes[0]->code );
    }
    
    function testShouldUseExistingCodeForExistingMessages()
    {
        $this->noteFinder()->insert('myCode','This is my message');
        $this->insertProduct('sku');
        $this->import('sku, make, model, year, note_message' . "\n" .
                      'sku, honda, civic, 2000, "This is my message"');
        
        $fitId = $this->getFitIdForSku('sku');
        $notes = $this->noteFinder()->getNotes( $fitId );
        $this->assertEquals( 'myCode', $notes[0]->code );
    }
    
    function testShouldUseExistingCodeForExistingMessages_AndTrimmingSpaces()
    {
        $this->noteFinder()->insert('myCode','This is my message  ');
        $this->insertProduct('sku');
        $this->import('sku, make, model, year, note_message' . "\n" .
                      'sku, honda, civic, 2000, "  This is my message"');
        
        $fitId = $this->getFitIdForSku('sku');
        $notes = $this->noteFinder()->getNotes( $fitId );
        $this->assertEquals( 'myCode', $notes[0]->code );
    }
    
    function testShouldHandleRowsWithBlankNoteCode()
    {        
        $this->insertProduct('sku2');
        $this->import('"year_start","year_end","Make","Model","Sku","notes","note_message"
1990,2009,"Acura","Integra","sku2",,"this is my message"
');
        
        $fitId = $this->getFitIdForSku('sku2');
        $notes = $this->noteFinder()->getNotes( $fitId );
        $this->assertEquals( 1, count($notes), 'should handle rows with blank note code');
    }
    
}