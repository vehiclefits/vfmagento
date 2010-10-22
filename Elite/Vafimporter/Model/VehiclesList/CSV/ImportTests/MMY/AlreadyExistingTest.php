<?php
class Elite_Vafimporter_Model_VehiclesList_CSV_ImportTests_MMY_AlreadyExistingTest extends Elite_Vafimporter_TestCase
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
    
    function testWhenImportingMultipleTimesShouldSkipDuplicates()
    {
        $this->importVehiclesList($this->csvData);
        $expected_id = $this->levelFinder()->findEntityIdByTitle('make','honda');
        
        $this->importVehiclesList($this->csvData);
        $actual_id = $this->levelFinder()->findEntityIdByTitle( 'make', 'honda' );
        $this->assertEquals( $expected_id, $actual_id, 'when importing multiple times should skip duplicates' );
    }
}