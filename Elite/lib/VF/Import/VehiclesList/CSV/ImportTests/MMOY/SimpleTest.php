<?php
class VF_Import_VehiclesList_CSV_ImportTests_SimpleTest extends VF_Import_TestCase
{

    protected $csvData;
    protected $csvFile;

    function doSetUp()
    {
        $this->switchSchema('make,model,option,year');
        
        $this->csvData = 'make, model, option, year
honda, civic, base, 2000
honda, civic, base, 2001
honda, civic, base, 2002
acura, integra, base, 2000';
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
    
    function testWhenImportingMultipleTimesShouldSkipDuplicates()
    {
        $this->importVehiclesList($this->csvData);
        $expected_id = $this->levelFinder()->findEntityIdByTitle('make','honda');
        
        $this->importVehiclesList($this->csvData);
        $actual_id = $this->levelFinder()->findEntityIdByTitle( 'make', 'honda' );
        $this->assertEquals( $expected_id, $actual_id, 'when importing multiple times should skip duplicates' );
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