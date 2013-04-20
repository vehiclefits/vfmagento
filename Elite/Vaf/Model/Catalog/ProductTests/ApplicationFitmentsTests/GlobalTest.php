<?php
class Elite_Vaf_Model_Catalog_ProductTests_ApplicationFitmentsTests_GlobalTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{
    function doSetUp()
    {
        $schemaGenerator = new VF_Schema_Generator();
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
        $schemaGenerator = new VF_Schema_Generator();
        $schemaGenerator->dropExistingTables();
    }
    
    function testWhenSameYearShouldAddCorrectFitment()
    {
        $vehicle1 = $this->createMMY('Honda', 'Civic', '2000');
        $vehicle2 = $this->createMMY('Ford', 'F-150', '2000');
        
        $product = $this->getProduct(1);
        $product->addVafFit($vehicle1->toValueArray());
        
        $this->assertTrue($product->fitsVehicle($vehicle1));
    }    

    function testWhenSameYearShouldAddCorrectFitment2()
    {
        $vehicle1 = $this->createMMY('Honda', 'Civic', '2000');
        $vehicle2 = $this->createMMY('Ford', 'F-150', '2000');

        $product = $this->getProduct(1);
        $product->addVafFit($vehicle2->toValueArray());

        $this->assertTrue($product->fitsVehicle($vehicle2));
    }

    function testWhenSameYearShouldNotAddIncorrectFitment()
    {
        $vehicle1 = $this->createMMY('Honda', 'Civic', '2000');
        $vehicle2 = $this->createMMY('Ford', 'F-150', '2000');
        
        $this->assertEquals($vehicle1->getValue('year'), $vehicle2->getValue('year'));
        
        $product = $this->getProduct(1);
        $product->addVafFit($vehicle1->toValueArray());
        
        $this->assertFalse($product->fitsVehicle($vehicle2));
    }
}