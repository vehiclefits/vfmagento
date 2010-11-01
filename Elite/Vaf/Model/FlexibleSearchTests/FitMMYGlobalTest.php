<?php
class Elite_Vaf_Model_FlexibleSearchTests_FitMMYGlobalTest extends Elite_Vaf_TestCase
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
    
    function testTest()
    {
        $vehicle1 = $this->createMMY('Honda', 'Civic', '2000');
        $vehicle2 = $this->createMMY('Ford', 'F-150', '2000');
        
        $this->insertFitmentMMY($vehicle1, 1);
        $this->insertFitmentMMY($vehicle2, 2);
        
        $this->setRequestParams($vehicle1->toValueArray());
        $this->assertEquals( array(1), Elite_Vaf_Helper_Data::getInstance()->getProductIds() );
    }
}