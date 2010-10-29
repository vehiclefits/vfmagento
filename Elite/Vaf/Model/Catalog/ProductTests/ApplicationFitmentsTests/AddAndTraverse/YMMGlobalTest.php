<?php
class Elite_Vaf_Model_Catalog_ProductTests_ApplicationFitmentsTests_AddAndTraverse_YMMGlobalTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
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
    
    function testShouldNotCrossover_Global()
    {
        $product = $this->getProduct(1);

        $vehicle1 = $this->createVehicle(array('year'=>2000, 'make'=>'Honda', 'model'=>'Civic'));
        $vehicle2 = $this->createVehicle(array('year'=>2001, 'make'=>'Honda', 'model'=>'Civic'));

        $result = $product->addVafFit( $vehicle1->toValueArray() );
        
        $product->setCurrentlySelectedFit($vehicle1);
        $this->assertTrue( $product->fitsSelection() );
        
        $product->setCurrentlySelectedFit($vehicle2);
        $this->assertFalse( $product->fitsSelection() );
    }
}