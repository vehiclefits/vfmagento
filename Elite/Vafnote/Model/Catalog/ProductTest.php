<?php
class Elite_Vafnote_model_Catalog_ProductTest extends Elite_Vaf_TestCase
{
    function testShouldFindNumberOfNotes()
    {
        $this->createNoteDefinition('code1','this is my message');
        $vehicle = $this->createMMY();
        $product = $this->newNoteProduct(1);
        $this->insertMappingMMY($vehicle, $product->getId());
        
        $product->addNote( $vehicle, 'code1' );
        $this->assertEquals( 1, $product->numberOfNotes($vehicle), 'should find number of notes for a vehicle' );
    }
    
    function testWhenProductDoesntFitVehicle()
    {
        $this->createNoteDefinition('code1','this is my message');
        $vehicle1 = $this->createMMY();
        $vehicle2 = $this->createMMY();
        $product = $this->newNoteProduct(1);
        $product->addNote( $vehicle1, 'code1' );
        $this->assertEquals( 0, $product->numberOfNotes($vehicle2), 'should find 0 notes when product doesnt fit vehicle' );
    }
    
}
