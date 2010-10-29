<?php
class Elite_Vaf_Model_Catalog_ProductTests_ApplicationFitmentsTests_AddTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{
	const PRODUCT_ID = 1;
    const PRODUCT_NAME = 'Widget';
    
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testAddSingle()
    {
        $product = $this->getProduct(self::PRODUCT_ID);
        $vehicle = $this->createMMY();
        $mapping_id = $product->addVafFit( $vehicle->toValueArray() );
        
        $actualRow = $this->getMappingRow( array('make_id'=>$vehicle->getLevel('make')->getId(),'model_id'=>$vehicle->getLevel('model')->getId(),'year_id'=>$vehicle->getLevel('year')->getId()));
        $this->assertEquals( $vehicle->getLevel('make')->getId(), $actualRow['make_id'] );
        $this->assertEquals( $vehicle->getLevel('model')->getId(), $actualRow['model_id'] );
        $this->assertEquals( $vehicle->getLevel('year')->getId(), $actualRow['year_id'] );
        $this->assertEquals( self::PRODUCT_ID, $actualRow['entity_id'] );
        
        $product->setCurrentlySelectedFit($vehicle);
        $this->assertTrue( $product->fitsSelection() );
    }
    
    function testAddMultiple()
    {
        $product = $this->getProduct(self::PRODUCT_ID);

        $vehicle1 = $this->createMMY('Make', 'Model1');
        $vehicle2 = $this->createMMY('Make', 'Model2');

        $mapping_id = $product->addVafFit( array('make'=>$vehicle1->getLevel('make')->getId()) );    
        
        $actual = $product->getFitModels();
        
        $this->assertEquals( 2, count($actual) );
        $fit1 = $actual[0];
        $fit2 = $actual[1];
        $this->assertEquals( $vehicle1->getLevel('model')->getId(), $fit1->getLevel('model')->getId() );
        $this->assertEquals( $vehicle2->getLevel('model')->getId(), $fit2->getLevel('model')->getId() );
    }
    
    function testShouldNotAcceptDuplicates()
    {
        $product = $this->getProduct(self::PRODUCT_ID);

        $vehicle1 = $this->createMMY('Make', 'Model1');
        
        $mapping_id1 = $product->addVafFit( $vehicle1->toValueArray() );    
        $mapping_id2 = $product->addVafFit( $vehicle1->toValueArray() );    
        
        $actual = $product->getFitModels();
        $this->assertEquals( 1, count($actual) );
        
        $this->assertTrue($mapping_id1 > 0, 'first time a mapping is inserted it gets an id');
        $this->assertEquals( $mapping_id1, $mapping_id2, 'if trying to insert duplicate mapping return the existing mapping id');
    }
}