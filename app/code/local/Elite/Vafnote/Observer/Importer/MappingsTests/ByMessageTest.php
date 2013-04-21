<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Elite_Vafnote_Observer_Importer_MappingsTests_ByMessageTest extends Elite_Vafnote_Observer_Importer_MappingsTests_TestCase
{    
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
 
    function testShouldIgnoreRowsWithCodeButNoMessage_WithoutComma()
    {        
        $this->insertProduct('sku1');
        $this->import('"year_start","year_end","make","model","sku","notes","note_message"
1990,2009,"Acura","Integra","sku1",code1
');
        
        $fitId = $this->getFitIdForSku('sku1');
        $notes = $this->noteFinder()->getNotes( $fitId );
        $this->assertEquals( 0, count($notes));
    }
     
    function testShouldIgnoreRowsWithCodeButNoMessage_WithComma()
    {        
        $this->insertProduct('sku1');
        $this->import('"year_start","year_end","make","model","sku","notes","note_message"
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
        $this->import('"year_start","year_end","make","model","sku","notes","note_message"
1990,2009,"Acura","Integra","sku2",,"this is my message"
');
        
        $fitId = $this->getFitIdForSku('sku2');
        $notes = $this->noteFinder()->getNotes( $fitId );
        $this->assertEquals( 1, count($notes), 'should handle rows with blank note code');
    }
    
}