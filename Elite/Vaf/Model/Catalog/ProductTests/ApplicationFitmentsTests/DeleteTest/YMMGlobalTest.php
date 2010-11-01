<?php
class Elite_Vaf_Model_Catalog_ProductTests_ApplicationFitmentsTests_DeleteTest_YMMGlobalTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{
    function doSetUp()
    {
        $schemaGenerator = new Elite_Vaf_Model_Schema_Generator();
        $schemaGenerator->dropExistingTables();
        $schemaGenerator->execute(array(
            'year' => array('global'=>true),
            'make' => array('global'=>true),
            'model'
        ));
        $this->startTransaction();
    }
    
    function doTearDown()
    {
        $schemaGenerator = new Elite_Vaf_Model_Schema_Generator();
        $schemaGenerator->dropExistingTables();
    }
    
    function testDelete()
    {
        $product = $this->getProduct(1);
        $product->addVafFit( $this->createMMY()->toValueArray() );
        $this->assertEquals( 1, count($product->getFits()) );
        
        $product = $this->getProduct(1);
        $mappings = $product->getFits();
        $product->deleteVafFit( $mappings[0]->id );
        
        $product = $this->getProduct(1);
        $this->assertEquals( 0, count($product->getFits()), 'should delete fitments' );
    }
    
    function testShouldDeleteFitmentNotesWhenDeletingMake()
    {
        $product = $this->getProduct(1);
        $vehicle = $this->createYMM('2000','Honda','Civic');
        $mapping_id = $this->insertMappingMMY( $vehicle, $product->getId() );
        
        $this->noteFinder()->insertNoteRelationship($mapping_id, 'code1');
        
        $product->deleteVafFit($mapping_id);
        
        $result = $this->query('select count(*) from elite_mapping_notes');
        $this->assertEquals( 0, $result->fetchColumn(), 'should delete fitment notes when deleting a fitment' );
    }
    
    function testShouldNotCrossover()
    {
        $product = $this->getProduct(1);
        $vehicle1 = $this->createYMM('2000','Honda','Civic');
        $vehicle2 = $this->createYMM('2000','Ford','F-150');
       
        $mapping1 = $product->addVafFit( $vehicle1->toValueArray() ); 
        $mapping2 = $product->addVafFit( $vehicle2->toValueArray() ); 
        
        $product->deleteVafFit($mapping1);
        
        $product->setCurrentlySelectedFit($vehicle2);
        $this->assertTrue($product->fitsSelection());
    }
}