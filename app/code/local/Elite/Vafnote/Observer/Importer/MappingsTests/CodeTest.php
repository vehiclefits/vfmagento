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