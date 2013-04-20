<?php
class VF_Import_VehiclesList_CSV_ImportTests_MMY_DashTest extends VF_Import_TestCase
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
        $finder = new VF_Vehicle_Finder(new VF_Schema());
        $vehicles = $finder->findByLevels(array('make'=>'honda', 'model'=>'ci-vic', 'year'=>'2000' ));
        $this->assertEquals(1,count($vehicles));
    }
    
    function test2()
    {
        $this->importVehiclesList('make, model, year
honda, ci-vic, 2000
honda, ci-vic, 2001');
		$finder = new VF_Vehicle_Finder(new VF_Schema());
        $vehicles = $finder->findByLevels(array('make'=>'honda', 'model'=>'ci-vic', 'year'=>'2001' ));
        $this->assertEquals(1,count($vehicles));
    }
    
    function test3()
    {
        $this->importVehiclesList('make, model, year
honda, ci-vic, 2000
honda, ci-vic, 2001');
		$finder = new VF_Vehicle_Finder(new VF_Schema());
        $result = $this->query('select count(*) from elite_1_definition;');
        $this->assertEquals(2,$result->fetchColumn());
    }
    
    function test4()
    {
        $this->importVehiclesList('make, model, year
honda, ci-vic, 2000
honda, civi-c, 2000');
		$finder = new VF_Vehicle_Finder(new VF_Schema());
        $result = $this->query('select count(*) from elite_1_definition;');
        $this->assertEquals(2,$result->fetchColumn());
    }

}