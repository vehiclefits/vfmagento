<?php
class Elite_Vafimporter_Model_VehiclesList_CSV_ImportTests_MMY_DashTest extends Elite_Vafimporter_TestCase
{

    protected $csvData;
    protected $csvFile;

    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function test1()
    {
        $this->importVehiclesList('make, model, year
honda, ci-vic, 2000
honda, ci-vic, 2001');
        $finder = new Elite_Vaf_Model_Vehicle_Finder(new Elite_Vaf_Model_Schema());
        $vehicles = $finder->findByLevels(array('make'=>'honda', 'model'=>'ci-vic', 'year'=>'2000' ));
        $this->assertEquals(1,count($vehicles));
    }
    
    function test2()
    {
        $this->importVehiclesList('make, model, year
honda, ci-vic, 2000
honda, ci-vic, 2001');
		$finder = new Elite_Vaf_Model_Vehicle_Finder(new Elite_Vaf_Model_Schema());
        $vehicles = $finder->findByLevels(array('make'=>'honda', 'model'=>'ci-vic', 'year'=>'2001' ));
        $this->assertEquals(1,count($vehicles));
    }
    
    function test3()
    {
        $this->importVehiclesList('make, model, year
honda, ci-vic, 2000
honda, ci-vic, 2001');
		$finder = new Elite_Vaf_Model_Vehicle_Finder(new Elite_Vaf_Model_Schema());
        $result = $this->query('select count(*) from elite_definition;');
        $this->assertEquals(2,$result->fetchColumn());
    }
    
    function test4()
    {
        $this->importVehiclesList('make, model, year
honda, ci-vic, 2000
honda, civi-c, 2000');
		$finder = new Elite_Vaf_Model_Vehicle_Finder(new Elite_Vaf_Model_Schema());
        $result = $this->query('select count(*) from elite_definition;');
        $this->assertEquals(2,$result->fetchColumn());
    }

}