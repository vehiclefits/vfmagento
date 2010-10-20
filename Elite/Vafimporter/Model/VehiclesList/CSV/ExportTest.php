<?php
class Elite_Vafimporter_Model_VehiclesList_CSV_ExportTest extends Elite_Vafimporter_Model_VehiclesList_CSV_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $this->importVehiclesList('make, model, year
honda, civic, 2000
honda, civic, 2001
acura,integra,2000
acura,integra,2004');
    }
    
    function testExport()
    {
        $exporter = $this->getDefinitionsExport();
        $output = explode( "\n", $exporter->export() );
        $this->assertEquals( 'make,model,year', $output[0] );
        
    }
       
}