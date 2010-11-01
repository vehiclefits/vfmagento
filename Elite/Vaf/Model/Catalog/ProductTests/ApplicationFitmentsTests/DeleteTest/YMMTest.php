<?php
class Elite_Vaf_Model_Catalog_ProductTests_ApplicationFitmentsTests_DeleteTest_YMMTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{
	function doSetUp()
    {
        $this->switchSchema('year,make,model');
    }
    
    function testDelete()
    {
        $product = $this->getProduct(1);
        $product->addVafFit( $this->createMMY()->toValueArray() );
        $this->assertEquals( 1, count($product->getFits()) );
        
        $product = $this->getProduct(1);
        $Fitments = $product->getFits();
        $product->deleteVafFit( $Fitments[0]->id );
        
        $product = $this->getProduct(1);
        $this->assertEquals( 0, count($product->getFits()), 'should delete fitments' );
    }
    
	function testShouldDeleteFitmentNotesWhenDeletingMake()
	{
		$product = $this->getProduct(1);
		$vehicle = $this->createYMM('2000','Honda','Civic');
		$Fitment_id = $this->insertFitmentMMY( $vehicle, $product->getId() );
		
		$this->noteFinder()->insertNoteRelationship($Fitment_id, 'code1');
		
		$product->deleteVafFit($Fitment_id);
		
		$result = $this->query('select count(*) from elite_Fitment_notes');
		$this->assertEquals( 0, $result->fetchColumn(), 'should delete fitment notes when deleting a fitment' );
	}
}