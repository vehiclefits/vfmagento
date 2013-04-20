<?php
class VF_Import_VehiclesList_CSV_ImportTests_YMM_DuplicateTest extends VF_Import_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('year,make,model',true);
    }
    
    function testShouldStoreMakesUnderCorrectYear()
    {
        $this->importVehiclesList('"year","make","model",
"1990","STIHL","39",
"1991","STIHL","39",');

        $y1990 = $this->levelFinder()->findEntityIdByTitle('year','1990');
        $makes = $this->levelFinder()->listAll('make', $y1990);
        $this->assertEquals( 1, count($makes), 'should store makes under correct year');
    }
    
    function testShouldImportMakesOnlyOnce()
    {
        $this->importVehiclesList('"year","make","model",
"1990","STIHL","39",
"1990","STIHL","base",');

        $y1990 = $this->levelFinder()->findEntityIdByTitle('year','1990');
        $makes = $this->levelFinder()->listAll('make', $y1990);
        $this->assertEquals( 1, count($makes), 'should store makes under correct year');
    }
}