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
class Elite_Vafnote_SnippetTest extends Elite_Vaf_TestCase
{
    const PRODUCT_ID = 1;
    const NOTE_CODE = 1;
    const NOTE_CODE1 = 1;
    const NOTE_CODE2 = 2;
    
    function testNoVehicle()
    {
        $vehicle1 = $this->createMMY( '1', '1', '1' );
        $mapping_id1 = $this->insertMappingMMY( $vehicle1, self::PRODUCT_ID );
        $noteId = $this->noteFinder()->insert( self::NOTE_CODE1, 'test message 1' );
        $this->noteFinder()->insertNoteRelationship( $mapping_id1, $noteId );
        $this->assertEquals( 'Select a vehicle to view fitment notes', $this->includeSnippet(self::PRODUCT_ID), 'when no vehicle selected, should prompt user to select vehicle' );
    }
    
    function testNoNotes()
    {
        $vehicle = $this->createMMY();
        $this->insertMappingMMY( $vehicle, 1 );
        $this->setRequestParams( $vehicle->toValueArray() );        
        $this->assertEquals( 'There are no notes for your vehicle (test make test model test year)', $this->includeSnippet(2), 'when product id differ should not find notes' );
    }
    
    function testShouldFindNotesForAMapping()
    {
        $vehicle = $this->createMMY( '1', '1', '1'  );
        $this->setRequestParams( $vehicle->toValueArray() );
        $mapping_id = $this->insertMappingMMY( $vehicle, self::PRODUCT_ID );
        $noteId = $this->noteFinder()->insert( self::NOTE_CODE, 'test message' );
        $this->noteFinder()->insertNoteRelationship( $mapping_id, $noteId );
        $this->assertEquals( 'test message <br />', $this->includeSnippet(self::PRODUCT_ID), 'should find notes for a mapping' );
    }
    
    function testShouldOnlyFindNotesForSelectedVehicle()
    {
        $vehicle1 = $this->createMMY( '1', '1', '1' );
        $vehicle2 = $this->createMMY( '2', '2', '2' );
        $this->setRequestParams( $vehicle2->toValueArray() );
        $mapping_id1 = $this->insertMappingMMY( $vehicle1, self::PRODUCT_ID );
        $mapping_id2 = $this->insertMappingMMY( $vehicle2, self::PRODUCT_ID );
        $noteId1 = $this->noteFinder()->insert( self::NOTE_CODE1, 'test message 1' );
        $noteId2 = $this->noteFinder()->insert( self::NOTE_CODE2, 'test message 2' );
        $this->noteFinder()->insertNoteRelationship( $mapping_id1, $noteId1 );
        $this->noteFinder()->insertNoteRelationship( $mapping_id2, $noteId2 );
        $this->assertEquals( 'test message 2 <br />', $this->includeSnippet(self::PRODUCT_ID), 'should only find notes for the selected vehicle' );
    }
    
    function testShouldNotFindNotesForNonVehicle()
    {
        $vehicle1 = $this->createMMY( '1', '1', '1' );
        $vehicle2 = $this->createMMY( '2', '2', '2' );
        $this->setRequestParams( $vehicle1->toValueArray() );
        $mapping_id1 = $this->insertMappingMMY( $vehicle1, self::PRODUCT_ID );
        $mapping_id2 = $this->insertMappingMMY( $vehicle2, self::PRODUCT_ID );
        $noteId1 = $this->noteFinder()->insert( self::NOTE_CODE1, 'test message 1' );
        $noteId2 = $this->noteFinder()->insert( self::NOTE_CODE2, 'test message 2' );
        $this->noteFinder()->insertNoteRelationship( $mapping_id1, $noteId1 );
        $this->noteFinder()->insertNoteRelationship( $mapping_id2, $noteId2 );
        $this->assertNotEquals( 'test message 2 <br />', $this->includeSnippet(self::PRODUCT_ID), 'should not find notes for non selected vehicle' );
    }
    
    function testUniversalProductShouldHaveNoNotes()
    {
        $vehicle = $this->createMMY();
        $this->newProduct(self::PRODUCT_ID)->setUniversal(true);
        $mapping_id = $this->insertMappingMMY( $vehicle, self::PRODUCT_ID );
        $noteId = $this->noteFinder()->insert( self::NOTE_CODE1, 'test message 1' );
        $this->noteFinder()->insertNoteRelationship( $mapping_id, $noteId );
        $this->setRequestParams( $vehicle->toValueArray() );
        
        $this->assertEquals( 'Product is universal and has no fitment notes', $this->includeSnippet(self::PRODUCT_ID), 'universal product should have no notes' );
    }
    
    protected function includeSnippet( $product_id )
    {
        ob_start();
        $this->snippet( $product_id );
        $output = ob_get_clean();
        return $output;
    }
    
    protected function snippet( $product_id )
    {
        // begin fitment fitment notes
        
        $noteFinder = new Elite_Vafnote_Model_Finder();
        $vehicle = Elite_Vaf_Helper_Data::getInstance()->vehicleSelection()->getFirstVehicle();
        
        $product = new Elite_Vaf_Model_Catalog_Product();
        $product->setId( $product_id );
        
        if( null == $vehicle )
        {
            echo 'Select a vehicle to view fitment notes';
        }
        else if( $product->isUniversal() )
        {
            echo 'Product is universal and has no fitment notes';
        }
        else
        {
            $mapping_id = $product->getMappingId( $vehicle );   
            $notes = $noteFinder->getNotes( $mapping_id );
            
            foreach( $notes as $note )
            {
                echo $note->message . ' <br />';
            }
            
            if( !count($notes))
            {
                echo 'There are no notes for your vehicle (' . $vehicle->__toString() . ')';
            }
        }

        // end fitment fitment notes
    }
}
