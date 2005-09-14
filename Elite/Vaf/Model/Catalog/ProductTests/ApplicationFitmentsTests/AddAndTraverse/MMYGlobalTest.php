<?php
class Elite_Vaf_Model_Catalog_ProductTests_ApplicationFitmentsTests_AddAndTraverse_MMYGlobalTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{
    function doSetUp()
    {
        $schemaGenerator = new Elite_Vaf_Model_Schema_Generator();
        $schemaGenerator->dropExistingTables();
        $schemaGenerator->execute(array(
            'make' => array('global'=>true),
            'model',
            'year' => array('global'=>true)
        ));
        $this->startTransaction();
    }
    
    function doTearDown()
    {
        $schemaGenerator = new Elite_Vaf_Model_Schema_Generator();
        $schemaGenerator->dropExistingTables();
    }
    
    function testShouldNotCrossover_Global2()
    {
        $product = $this->getProduct(1);

        $vehicle2 = $this->createVehicle(array('make'=>'Ford', 'model'=>'F-150', 'year'=>'2000'));
        $vehicle1 = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>'2000'));
        
        $result = $product->addVafFit( $vehicle1->toValueArray() );
        
        $this->assertTrue( $product->fitsVehicle($vehicle1) );
        $this->assertFalse( $product->fitsVehicle($vehicle2) );
        
        
    }
}