<?php
class VF_Import_VehiclesList_CSV_ImportTests_MMY_SimpleTest extends VF_Import_TestCase
{

    protected $csvData;

    function doSetUp()
    {
        $this->switchSchema('make,model,year');
        
        $this->csvData = 'make, model, year
honda, civic, 2000
honda, civic, 2001
honda, civic, 2002
acura, integra, 2000';
    }
    
    function testShouldImportMake()
    {
        $this->importVehiclesList($this->csvData);
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda')), 'importer should be able to load makes (root levels) properly' );
    }
    
    function testShouldImportMake2()
    {
        $this->importVehiclesList($this->csvData);
        $this->assertTrue( $this->vehicleExists(array('make'=>'acura')), 'importer should be able to load makes (root levels) properly' );
    }
    
    function testSameMakeDifferentModel()
    {
        $this->importVehiclesList( "make, model, year\n" .
            "makeA,modelA,2000\n" .
            "makeB,modelA,2000");
        
        $makeA = new VF_Level( 'make', $this->levelFinder()->findEntityIdByTitle( 'make', 'makeA' ) );
        $makeB = new VF_Level( 'make', $this->levelFinder()->findEntityIdByTitle( 'make', 'makeB' ) );
        
        $this->assertEquals( 1, count($makeA->getChildren()), 'when a model name is not unique, should be stored under the proper parent' );
        $this->assertEquals( 1, count($makeB->getChildren()), 'when a model name is not unique, should be stored under the proper parent' );
    }
    
    function testShouldImportYear2000()
    {
        $this->importVehiclesList($this->csvData);
        $this->assertTrue( $this->vehicleExists(array('year'=>'2000')), 'should import year 2000' );
    }
    
    function testShouldImportYear2001()
    {
        $this->importVehiclesList($this->csvData);
        $this->assertTrue( $this->vehicleExists(array('year'=>'2001')), 'should import year 2001' );
    }
    
    function testShouldImportYear2002()
    {
        $this->importVehiclesList($this->csvData);
        $this->assertTrue( $this->vehicleExists(array('year'=>'2002')), 'should import year 2002' );
    }

}