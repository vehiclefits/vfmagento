<?php
class Elite_Vaf_Model_Catalog_ProductTests_ApplicationFitmentsTests_AddAndTraverseTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{
    function testAddMultipleMake()
    {
        $product = $this->getProduct(1);

        $vehicle1 = $this->createMMY('Make', 'Model1');
        $vehicle2 = $this->createMMY('Make', 'Model2');

        $result = $product->doAddFit( $vehicle1->getLevel('make') );    
        
        $this->assertEquals( $vehicle1->getValue('model'), $result[0]->getValue('model'), 'should add multiple models for a make' );
        $this->assertEquals( $vehicle2->getValue('model'), $result[1]->getValue('model'), 'should add multiple models for a make' );
    }
    
    function testAddModel()
    {
        $product = $this->getProduct(1);

        $vehicle1 = $this->createMMY('Make', 'Model1');
        $vehicle2 = $this->createMMY('Make', 'Model2');

        $result = $product->doAddFit( $vehicle2->getLevel('model') );    
        
        $this->assertEquals( $vehicle2->getValue('model'), $result[0]->getValue('model'), 'should add model' );
    }
    
    function testShouldNotCrossover()
    {
        $this->switchSchema('year,make,model');
        $product = $this->getProduct(1);

        $vehicle1 = $this->createVehicle(array('year'=>2000, 'make'=>'Honda', 'model'=>'Civic'));
        $vehicle2 = $this->createVehicle(array('year'=>2001, 'make'=>'Honda', 'model'=>'Civic'));

        $result = $product->addVafFit( $vehicle1->toValueArray() );
        
        $product->setCurrentlySelectedFit($vehicle1);
        $this->assertTrue( $product->fitsSelection() );
        
        $product->setCurrentlySelectedFit($vehicle2);
        $this->assertFalse( $product->fitsSelection() );
    }
    
    function testShouldNotCrossover_Global()
    {
        $schemaGenerator = new Elite_Vaf_Model_Schema_Generator();
        $schemaGenerator->dropExistingTables();
        $schemaGenerator->execute(array(
            'year' => array('global'=>true),
            'make' => array('global'=>true),
            'model'
        ));
        $this->startTransaction();
        
        $product = $this->getProduct(1);

        $vehicle1 = $this->createVehicle(array('year'=>2000, 'make'=>'Honda', 'model'=>'Civic'));
        $vehicle2 = $this->createVehicle(array('year'=>2001, 'make'=>'Honda', 'model'=>'Civic'));

        $result = $product->addVafFit( $vehicle1->toValueArray() );
        
        $product->setCurrentlySelectedFit($vehicle1);
        $this->assertTrue( $product->fitsSelection() );
        
        $product->setCurrentlySelectedFit($vehicle2);
        $this->assertFalse( $product->fitsSelection() );
        
        $schemaGenerator = new Elite_Vaf_Model_Schema_Generator();
        $schemaGenerator->dropExistingTables();
    }
    
    function testShouldNotCrossover_Global2()
    {
        $schemaGenerator = new Elite_Vaf_Model_Schema_Generator();
        $schemaGenerator->dropExistingTables();
        $schemaGenerator->execute(array(
            'make' => array('global'=>true),
            'model',
            'year' => array('global'=>true)
        ));
        $this->startTransaction();
        
        $product = $this->getProduct(1);

        $vehicle2 = $this->createVehicle(array('make'=>'Ford', 'model'=>'F-150', 'year'=>'2000'));
        $vehicle1 = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>'2000'));
        

        $result = $product->addVafFit( $vehicle1->toValueArray() );
        
        $product->setCurrentlySelectedFit($vehicle1);
        $this->assertTrue( $product->fitsSelection() );
        
        $product->setCurrentlySelectedFit($vehicle2);
        $this->assertFalse( $product->fitsSelection() );
        
        $schemaGenerator = new Elite_Vaf_Model_Schema_Generator();
        $schemaGenerator->dropExistingTables();
    }
}