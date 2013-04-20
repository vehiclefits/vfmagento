<?php
class VF_FlexibleSearchTests_FitYMMGlobalTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $schemaGenerator = new VF_Schema_Generator();
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
        $schemaGenerator = new VF_Schema_Generator();
        $schemaGenerator->dropExistingTables();
    }
    
    function testTest()
    {
        $vehicle1 = $this->createVehicle(array('year'=>'2000','make'=>'Toyota','model'=>'Base'));
        $vehicle2 = $this->createVehicle(array('year'=>'1991','make'=>'Toyota','model'=>'Base'));
        
        $this->insertMappingMMY($vehicle1, 1);
        $this->insertMappingMMY($vehicle2, 1);
        
        $this->setRequestParams($vehicle1->toValueArray());
        $this->assertEquals( $vehicle1->toValueArray(), Elite_Vaf_Helper_Data::getInstance()->vehicleSelection()->toValueArray() );
    }
}