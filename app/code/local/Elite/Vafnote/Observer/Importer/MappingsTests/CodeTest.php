<?php
class Elite_Vafnote_Observer_Importer_MappingsTests_CodeTest extends Elite_Vafnote_Observer_Importer_MappingsTests_TestCase
{    
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $this->insertProduct('sku');
    }
    
    function testAlphaNumericCodes()
    {        
        $this->createNoteDefinition('abc','foo');
        $this->createNoteDefinition('xyz','bar');
        $this->import('sku, make, model, year, notes' . "\n" .
                      'sku, honda, civic, 2000, "abc,xyz"');
        
        $fitId = $this->getFitIdForSku('sku');
        $notes = $this->noteFinder()->getNotes( $fitId );
        $this->assertEquals( 'foo', $notes[0]->message );
        $this->assertEquals( 'bar', $notes[1]->message );
    }
    
    function testNumericCodes()
    {       
        $this->createNoteDefinition(1,'foo');
        $this->createNoteDefinition(2,'bar');
        $this->import('sku, make, model, year, notes' . "\n" .
                      'sku, honda, civic, 2000, "1,2"');
        
        $fitId = $this->getFitIdForSku('sku');
        $notes = $this->noteFinder()->getNotes( $fitId );
        $this->assertEquals( 'foo', $notes[0]->message );
        $this->assertEquals( 'bar', $notes[1]->message );
    }
    
}