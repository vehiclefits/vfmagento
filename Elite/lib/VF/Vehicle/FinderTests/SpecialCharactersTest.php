<?php
class VF_Vehicle_FinderTests_SpecialCharactersTest extends Elite_Vafimporter_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,trim,year');
    }

    function testShouldImport2()
    {
	$this->importVehiclesList('make,model,trim,year_start,year_end,Bolt_Pattern
MAZDA,PROTÉGÉ ,DX,1988,2000,8X165.1');

	$vehicle = $this->vehicleFinder()->findOneByLevels(array('make'=>'MAZDA','model'=>'PROTÉGÉ', 'trim'=>'dx', 'year'=>1990));
        $this->assertTrue(is_object($vehicle));
    }
}