<?php
class Elite_Vafnote_SnippetTest extends Elite_Vaf_TestCase
{
    const PRODUCT_ID = 1;
    const NOTE_CODE = 1;
    const NOTE_CODE1 = 1;
    const NOTE_CODE2 = 2;
    
    function testNoVehicle()
    {
        $vehicle1 = $this->createMMY( '1', '1', '1' );
        $Fitment_id1 = $this->insertFitmentMMY( $vehicle1, self::PRODUCT_ID );
        $this->noteFinder()->insert( self::NOTE_CODE1, 'test message 1' );
        $this->noteFinder()->insertNoteRelationship( $Fitment_id1, self::NOTE_CODE1 );
        $this->assertEquals( 'Select a vehicle to view fitment notes', $this->includeSnippet(self::PRODUCT_ID), 'when no vehicle selected, should prompt user to select vehicle' );
    }
    
    function testNoNotes()
    {
        $vehicle = $this->createMMY();
        $this->insertFitmentMMY( $vehicle, 1 );
        $this->setRequestParams( $vehicle->toValueArray() );        
        $this->assertEquals( 'There are no notes for your vehicle (test make test model test year)', $this->includeSnippet(2), 'when product id differ should not find notes' );
    }
    
    function testShouldFindNotesForAFitment()
    {
        $vehicle = $this->createMMY( '1', '1', '1'  );
        $this->setRequestParams( $vehicle->toValueArray() );
        $Fitment_id = $this->insertFitmentMMY( $vehicle, self::PRODUCT_ID );
        $this->noteFinder()->insert( self::NOTE_CODE, 'test message' );
        $this->noteFinder()->insertNoteRelationship( $Fitment_id, self::NOTE_CODE );
        $this->assertEquals( 'test message <br />', $this->includeSnippet(self::PRODUCT_ID), 'should find notes for a Fitment' );
    }
    
    function testShouldOnlyFindNotesForSelectedVehicle()
    {
        $vehicle1 = $this->createMMY( '1', '1', '1' );
        $vehicle2 = $this->createMMY( '2', '2', '2' );
        $this->setRequestParams( $vehicle2->toValueArray() );
        $Fitment_id1 = $this->insertFitmentMMY( $vehicle1, self::PRODUCT_ID );
        $Fitment_id2 = $this->insertFitmentMMY( $vehicle2, self::PRODUCT_ID );
        $this->noteFinder()->insert( self::NOTE_CODE1, 'test message 1' );
        $this->noteFinder()->insert( self::NOTE_CODE2, 'test message 2' );
        $this->noteFinder()->insertNoteRelationship( $Fitment_id1, self::NOTE_CODE1 );
        $this->noteFinder()->insertNoteRelationship( $Fitment_id2, self::NOTE_CODE2 );
        $this->assertEquals( 'test message 2 <br />', $this->includeSnippet(self::PRODUCT_ID), 'should only find notes for the selected vehicle' );
    }
    
    function testShouldNotFindNotesForNonVehicle()
    {
        $vehicle1 = $this->createMMY( '1', '1', '1' );
        $vehicle2 = $this->createMMY( '2', '2', '2' );
        $this->setRequestParams( $vehicle1->toValueArray() );
        $Fitment_id1 = $this->insertFitmentMMY( $vehicle1, self::PRODUCT_ID );
        $Fitment_id2 = $this->insertFitmentMMY( $vehicle2, self::PRODUCT_ID );
        $this->noteFinder()->insert( self::NOTE_CODE1, 'test message 1' );
        $this->noteFinder()->insert( self::NOTE_CODE2, 'test message 2' );
        $this->noteFinder()->insertNoteRelationship( $Fitment_id1, self::NOTE_CODE1 );
        $this->noteFinder()->insertNoteRelationship( $Fitment_id2, self::NOTE_CODE2 );
        $this->assertNotEquals( 'test message 2 <br />', $this->includeSnippet(self::PRODUCT_ID), 'should not find notes for non selected vehicle' );
    }
    
    function testUniversalProductShouldHaveNoNotes()
    {
        $vehicle = $this->createMMY();
        $this->newProduct(self::PRODUCT_ID)->setUniversal(true);
        $Fitment_id = $this->insertFitmentMMY( $vehicle, self::PRODUCT_ID );
        $this->noteFinder()->insert( self::NOTE_CODE1, 'test message 1' );
        $this->noteFinder()->insertNoteRelationship( $Fitment_id, self::NOTE_CODE1 );
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
        $vehicle = Elite_Vaf_Helper_Data::getInstance()->getFit();
        
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
            $Fitment_id = $product->getFitmentId( $vehicle );   
            $notes = $noteFinder->getNotes( $Fitment_id );
            
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
