<?php
class Elite_Vafnote_model_Catalog_ProductTest extends Elite_Vaf_TestCase
{
    function testShouldFindNumberOfNotes()
    {
        $this->createNoteDefinition('code1','this is my message');
        $vehicle = $this->createMMY();
        $product = $this->newNoteProduct(1);
        $product->addNote( $vehicle, 'code1' );
        $this->assertEquals( 1, $product->numberOfNotes($vehicle), 'should find number of notes for a vehicle' );
    }
    
    function newNoteProduct($id=0)
    {
        $product = $this->newProduct($id);
        return new Elite_Vafnote_Model_Catalog_Product($product);
    }
    
}
