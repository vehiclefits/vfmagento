<?php
class VF_Import_VehiclesList_CSV_ImportTests_YMM_GlobalTest extends VF_Import_TestCase
{
    function doSetUp()
    {
        $this->schemaGenerator()->dropExistingTables();
        $this->schemaGenerator()->execute(array(
            'year' => array('global'=>true),
            'model' => array('global'=>true)
        ));
        $this->startTransaction();
    }
    
    function testOneYear()
    {
        $this->importVehiclesList('year,model' . "\n" .
                                  '1995,CJ7' . "\n" . 
                                  '1995,CJ8');
        $vehicle1 = $this->vehicleFinder()->findOneByLevels(array('model'=>'CJ7', 'year'=>'1995'));
        $vehicle2 = $this->vehicleFinder()->findOneByLevels(array('model'=>'CJ8', 'year'=>'1995'));
        $this->assertEquals($vehicle1->getValue('year'), $vehicle2->getValue('year'));
    }
    
    function testOneYear2()
    {
        $this->importVehiclesList('year,model' . "\n" .
                                  '1995,CJ7' . "\n" . 
                                  '1995,CJ8');
        $vehicle1 = $this->vehicleFinder()->findOneByLevels(array('model'=>'CJ7', 'year'=>'1995'));
        $vehicle2 = $this->vehicleFinder()->findOneByLevels(array('model'=>'CJ8', 'year'=>'1995'));
        $count = $this->getReadAdapter()->query('select count(*) from elite_level_1_year')->fetchColumn();
        $this->assertEquals(1,$count);
    }
    
    function testOneModel()
    {
        $this->importVehiclesList('year,model' . "\n" .
                                  '1995,CJ7' . "\n" . 
                                  '1996,CJ7');
        $vehicle1 = $this->vehicleFinder()->findOneByLevels(array('model'=>'CJ7', 'year'=>'1995'));
        $vehicle2 = $this->vehicleFinder()->findOneByLevels(array('model'=>'CJ7', 'year'=>'1996'));
        $this->assertEquals($vehicle1->getValue('model'), $vehicle2->getValue('model'));
    }
    
    function testOneModel2()
    {
        $this->importVehiclesList('year,model' . "\n" .
                                  '1995,CJ7' . "\n" . 
                                  '1996,CJ7');
        $vehicle1 = $this->vehicleFinder()->findOneByLevels(array('model'=>'CJ7', 'year'=>'1995'));
        $vehicle2 = $this->vehicleFinder()->findOneByLevels(array('model'=>'CJ7', 'year'=>'1996'));
        $count = $this->getReadAdapter()->query('select count(*) from elite_level_1_model')->fetchColumn();
        $this->assertEquals(1,$count);
    }
    
    
}